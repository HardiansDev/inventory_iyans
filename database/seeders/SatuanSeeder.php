<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Seeder;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Satuan::create([
            'nama_satuan' => 'Pcs',
            'keterangan' => 'Satuan per piece',
        ]);

        Satuan::create([
            'nama_satuan' => 'Box',
            'keterangan' => 'Satuan per kotak',
        ]);

        Satuan::create([
            'nama_satuan' => 'Pack',
            'keterangan' => 'Satuan per bungkus',
        ]);

        Satuan::create([
            'nama_satuan' => 'Kg',
            'keterangan' => 'Satuan per kilogram',
        ]);

        Satuan::create([
            'nama_satuan' => 'Liter',
            'keterangan' => 'Satuan per liter',
        ]);
    }
}
