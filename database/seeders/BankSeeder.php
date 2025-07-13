<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Bank;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        Bank::insert([
            ['name' => 'BCA', 'code' => '014', 'no_rekening' => '1234567890'],
            ['name' => 'BRI', 'code' => '002', 'no_rekening' => '9876543210'],
            ['name' => 'Mandiri', 'code' => '008', 'no_rekening' => '4567891230'],
            ['name' => 'BSI', 'code' => '067', 'no_rekening' => '8765891230'],
        ]);
    }
}
