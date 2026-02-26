<?php

namespace App\Console\Commands;

use App\Models\Ticket;
use Illuminate\Console\Command;

class ResetDailyQueue extends Command
{
    protected $signature = 'queue:reset-daily';

    protected $description = 'Cancel all remaining waiting/calling tickets from previous days and reset queue state';

    public function handle(): int
    {
        $cancelled = Ticket::whereIn('status', ['waiting', 'calling'])
            ->whereDate('created_at', '<', today())
            ->update([
                'status' => 'cancelled',
                'completed_at' => now(),
                'notes' => 'Auto-cancelled: antrian direset otomatis di awal hari baru.',
            ]);

        $this->info("Reset antrian selesai. {$cancelled} tiket dibatalkan otomatis.");

        return self::SUCCESS;
    }
}
