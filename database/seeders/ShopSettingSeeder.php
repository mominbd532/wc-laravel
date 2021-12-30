<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShopSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shop_settings')->insert(
            [
                [
                    'key' => 'shop_logo',
                    'value' => '#',
                ],
                [
                    'key' => 'shop_name',
                    'value' => 'Your Name',
                ],
                [
                    'key' => 'shop_address',
                    'value' => 'Your Address',
                ],
                [
                    'key' => 'shop_email',
                    'value' => 'abc@gmail.com',
                ],
                [
                    'key' => 'shop_phone',
                    'value' => '01800000000',
                ],
                [
                    'key' => 'invoice_footer',
                    'value' => 'Test Info',
                ],
                
            ]
        );

    }
}
