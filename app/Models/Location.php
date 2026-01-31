<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'address',
        'is_active',
        'average_service_time',
        'open_time',
        'close_time',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'average_service_time' => 'integer',
            'open_time' => 'datetime:H:i',
            'close_time' => 'datetime:H:i',
        ];
    }

    public function counters(): HasMany
    {
        return $this->hasMany(Counter::class);
    }

    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function activeCounters(): HasMany
    {
        return $this->counters()->where('is_active', true);
    }

    public function waitingTickets(): HasMany
    {
        return $this->tickets()->where('status', 'waiting')->orderBy('created_at');
    }

    public function todayTickets(): HasMany
    {
        return $this->tickets()->whereDate('created_at', today());
    }

    public function generateTicketNumber(): string
    {
        $todayCount = $this->todayTickets()->count() + 1;
        return sprintf('%s-%03d', $this->code, $todayCount);
    }

    public function getEstimatedWaitTime(int $position): int
    {
        $activeCounters = $this->activeCounters()->count();
        if ($activeCounters === 0) {
            return $position * $this->average_service_time;
        }

        return (int) ceil(($position / $activeCounters) * $this->average_service_time);
    }

    public function isOpen(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now()->format('H:i');
        return $now >= $this->open_time->format('H:i') && $now <= $this->close_time->format('H:i');
    }
}
