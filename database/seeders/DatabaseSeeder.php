<?php

namespace Database\Seeders;

use App\Models\Counter;
use App\Models\Location;
use App\Models\ServiceCategory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@antriyuk.test',
            'role' => 'admin',
        ]);

        // Create Locations
        $customerService = Location::create([
            'name' => 'Customer Service',
            'code' => 'CS',
            'description' => 'Layanan pelanggan untuk pertanyaan umum dan keluhan',
            'address' => 'Lantai 1, Gedung Utama',
            'average_service_time' => 10,
            'open_time' => '08:00',
            'close_time' => '17:00',
        ]);

        $payment = Location::create([
            'name' => 'Pembayaran',
            'code' => 'PAY',
            'description' => 'Loket pembayaran tagihan dan transaksi',
            'address' => 'Lantai 1, Gedung Utama',
            'average_service_time' => 5,
            'open_time' => '08:00', 
            'close_time' => '16:00',
        ]);

        $registration = Location::create([
            'name' => 'Pendaftaran',
            'code' => 'REG',
            'description' => 'Pendaftaran layanan baru',
            'address' => 'Lantai 2, Gedung Utama',
            'average_service_time' => 15,
            'open_time' => '08:00',
            'close_time' => '15:00',
        ]);

        // Create Counters for each location
        foreach (range(1, 3) as $i) {
            Counter::create([
                'location_id' => $customerService->id,
                'name' => "Loket CS $i",
            ]);
        }

        foreach (range(1, 4) as $i) {
            Counter::create([
                'location_id' => $payment->id,
                'name' => "Loket Bayar $i",
            ]);
        }

        foreach (range(1, 2) as $i) {
            Counter::create([
                'location_id' => $registration->id,
                'name' => "Loket Daftar $i",
            ]);
        }

        // Create Operators
        User::factory()->create([
            'name' => 'Operator CS',
            'email' => 'operator-cs@antriyuk.test',
            'role' => 'operator',
            'location_id' => $customerService->id,
        ]);

        User::factory()->create([
            'name' => 'Operator Pembayaran',
            'email' => 'operator-pay@antriyuk.test',
            'role' => 'operator',
            'location_id' => $payment->id,
        ]);

        User::factory()->create([
            'name' => 'Operator Pendaftaran',
            'email' => 'operator-reg@antriyuk.test',
            'role' => 'operator',
            'location_id' => $registration->id,
        ]);

        // Create Service Categories
        ServiceCategory::create(['location_id' => $customerService->id, 'name' => 'Informasi Umum', 'description' => 'Pertanyaan seputar layanan']);
        ServiceCategory::create(['location_id' => $customerService->id, 'name' => 'Komplain', 'description' => 'Pengaduan dan keluhan']);
        ServiceCategory::create(['location_id' => $customerService->id, 'name' => 'Pembukaan Rekening', 'description' => 'Buka rekening baru']);

        ServiceCategory::create(['location_id' => $payment->id, 'name' => 'Pembayaran Tagihan', 'description' => 'Bayar tagihan bulanan']);
        ServiceCategory::create(['location_id' => $payment->id, 'name' => 'Transfer', 'description' => 'Transfer antar rekening']);

        ServiceCategory::create(['location_id' => $registration->id, 'name' => 'Pendaftaran Baru', 'description' => 'Daftar layanan baru']);
        ServiceCategory::create(['location_id' => $registration->id, 'name' => 'Perpanjangan', 'description' => 'Perpanjang layanan']);
    }
}
