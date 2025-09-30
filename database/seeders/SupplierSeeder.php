<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::create([
            'name' => 'PT Maju Jaya',
            'address' => 'Jl. Merdeka No. 1, Jakarta',
            'telp' => '0211234567',
            'email_sup' => 'info@majujaya.com',
            'name_prod' => 'Bahan Bangunan',
        ]);

        Supplier::create([
            'name' => 'CV Sumber Rejeki',
            'address' => 'Jl. Diponegoro No. 15, Bandung',
            'telp' => '0227654321',
            'email_sup' => 'cs@sumberrejeki.co.id',
            'name_prod' => 'Alat Tulis Kantor',
        ]);

        Supplier::create([
            'name' => 'UD Sejahtera Abadi',
            'address' => 'Jl. Gajah Mada No. 20, Surabaya',
            'telp' => '0319988776',
            'email_sup' => 'admin@sejahteraabadi.com',
            'name_prod' => 'Elektronik',
        ]);

        Supplier::create([
            'name' => 'PT Mitra Bersama',
            'address' => 'Jl. Sudirman No. 5, Yogyakarta',
            'telp' => '0274455667',
            'email_sup' => 'kontak@mitrabersama.id',
            'name_prod' => 'Bahan Makanan',
        ]);

        Supplier::create([
            'name' => 'CV Cahaya Baru',
            'address' => 'Jl. Ahmad Yani No. 30, Medan',
            'telp' => '0613344556',
            'email_sup' => 'support@cahayabaru.com',
            'name_prod' => 'Peralatan Rumah Tangga',
        ]);
    }
}
