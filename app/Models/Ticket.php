<?php

namespace App\Models;

use App\Events\TicketCalled;
use App\Events\TicketCreated;
use App\Events\TicketStatusChanged;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'counter_id',
        'served_by',
        'ticket_number',
        'customer_name',
        'customer_phone',
        'status',
        'called_at',
        'served_at',
        'completed_at',
        'service_time',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'called_at' => 'datetime',
            'served_at' => 'datetime',
            'completed_at' => 'datetime',
            'service_time' => 'integer',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function counter(): BelongsTo
    {
        return $this->belongsTo(Counter::class);
    }

    public function servedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'served_by');
    }

    public function getPositionAttribute(): int
    {
        if ($this->status !== 'waiting') {
            return 0;
        }

        return Ticket::where('location_id', $this->location_id)
            ->where('status', 'waiting')
            ->where('created_at', '<', $this->created_at)
            ->count() + 1;
    }

    public function getEstimatedWaitTimeAttribute(): int
    {
        if ($this->status !== 'waiting') {
            return 0;
        }

        return $this->location->getEstimatedWaitTime($this->position);
    }

    public function call(Counter $counter, User $operator): void
    {
        $this->update([
            'status' => 'calling',
            'counter_id' => $counter->id,
            'served_by' => $operator->id,
            'called_at' => now(),
        ]);

        broadcast(new TicketCalled($this))->toOthers();
        broadcast(new TicketStatusChanged($this))->toOthers();
    }

    public function startServing(): void
    {
        $this->update([
            'status' => 'serving',
            'served_at' => now(),
        ]);

        broadcast(new TicketStatusChanged($this))->toOthers();
    }

    public function complete(): void
    {
        $serviceTime = $this->served_at ? now()->diffInSeconds($this->served_at) : null;

        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'service_time' => $serviceTime,
        ]);

        broadcast(new TicketStatusChanged($this))->toOthers();
    }

    public function skip(): void
    {
        $this->update([
            'status' => 'skipped',
            'completed_at' => now(),
        ]);

        broadcast(new TicketStatusChanged($this))->toOthers();
    }

    public function cancel(): void
    {
        $this->update([
            'status' => 'cancelled',
            'completed_at' => now(),
        ]);

        broadcast(new TicketStatusChanged($this))->toOthers();
    }

    public static function createTicket(Location $location, ?string $customerName = null, ?string $customerPhone = null): self
    {
        $ticket = self::create([
            'location_id' => $location->id,
            'ticket_number' => $location->generateTicketNumber(),
            'customer_name' => $customerName,
            'customer_phone' => $customerPhone,
            'status' => 'waiting',
        ]);

        broadcast(new TicketCreated($ticket))->toOthers();

        return $ticket;
    }
}
