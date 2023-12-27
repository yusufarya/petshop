<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Size;
use App\Models\Unit;
use App\Models\Admin;
use App\Models\Brand;
use App\Models\Period;
use App\Models\Vendor;
use App\Models\Setting;
use App\Models\Village;
use App\Models\Category;
use App\Models\Customer;
use App\Models\AdminLevel;
use App\Models\SubDistrict;
use App\Models\DeliveryType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        Unit::create([
            'id' => '1',
            'initial' => 'Pcs',
            'name' => 'Pieces',
        ]);
        Unit::create([
            'id' => '2',
            'initial' => 'Box',
            'name' => 'Box',
        ]);
        
        Size::create([
            'id' => '1',
            'initial' => 'S',
            'name' => 'Small',
        ]);
        Size::create([
            'id' => '2',
            'initial' => 'M',
            'name' => 'Medium',
        ]);
        Size::create([
            'id' => '3',
            'initial' => 'L',
            'name' => 'Large',
        ]);
        Size::create([
            'id' => '4',
            'initial' => 'XL',
            'name' => 'Extra Large',
        ]);
        
        Category::create([
            'id' => '1',
            'name' => 'Kucing',
        ]);
        
        Category::create([
            'id' => '2',
            'name' => 'Anjing',
        ]);

        AdminLevel::create([
            'id' => '1',
            'name' => 'Owners',
        ]);
        
        AdminLevel::create([
            'id' => '2',
            'name' => 'Admin Staf',
        ]);

        Admin::create([
            'code' => 'ADM'.date('Ymd').'1',
            'fullname' => 'Owners Petshop',
            'username' => 'owners',
            'gender' => 'M',
            'phone' => '08986564321',
            'email' => 'owners@gmail.com',
            'password' => Hash::make('111111'),
            'level_id' => 1,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => 'owners',
        ]);

        Customer::create([
            'code' => 'PETS'.date('Ymd').'0001',
            'fullname' => 'User Test',
            'username' => 'user_test',
            'gender' => 'M',
            'phone' => '08986564321',
            'email' => 'usertest@gmail.com',
            'password' => Hash::make('111111'),
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        Vendor::create([
            'code' => '1',
            'name' => 'Vendor A',
            'address' => 'Tangerang',
        ]);

        
        DeliveryType::create([
            'name' => 'Lokal',
            'description' => 'Pengiriman lokal digunakan untuk pengiriman area tangerang.',
            'charge' => 5000
        ]);

        DeliveryType::create([
            'name' => 'Ekspedisi',
            'description' => 'Pengiriman menggunakan ekspedisi digunakan untuk pengiriman area luar tangerang.',
            'charge' => 13000
        ]);
    }
}
