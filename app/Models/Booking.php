<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'location_id',
        'service_category_id',
        'customer_name',
        'customer_phone',
        'booking_date',
        'booking_time',
        'status',
        'booking_code',
        'ticket_id',
    ];

    protected function casts(): array
    {
        return [
            'booking_date' => 'date',
            'booking_time' => 'datetime:H:i',
        ];
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function serviceCategory(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public static function generateBookingCode(Location $location): string
    {
        $todayCount = self::whereDate('created_at', today())
            ->where('location_id', $location->id)
            ->count() + 1;

        return sprintf('BK-%s-%03d', $location->code, $todayCount);
    }

    public function checkIn(): ?Ticket
    {
        if ($this->status !== 'confirmed' && $this->status !== 'pending') {
            return null;
        }

        $ticket = Ticket::createTicket(
            $this->location,
            $this->customer_name,
            $this->customer_phone,
            $this->service_category_id
        );

        $this->update([
            'status' => 'checked_in',
            'ticket_id' => $ticket->id,
        ]);

        return $ticket;
    }

    public function cancel(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    public function confirm(): void
    {
        $this->update(['status' => 'confirmed']);
    }
}
