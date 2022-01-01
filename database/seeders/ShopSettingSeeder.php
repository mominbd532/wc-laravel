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
                    'type' => 'image',
                ],
                [
                    'key' => 'shop_name',
                    'value' => 'Your Name',
                    'type' => 'text',
                ],
                [
                    'key' => 'shop_address',
                    'value' => 'Your Address',
                    'type' => 'text',
                ],
                [
                    'key' => 'shop_email',
                    'value' => 'abc@gmail.com',
                    'type' => 'text',
                ],
                [
                    'key' => 'shop_phone',
                    'value' => '01800000000',
                    'type' => 'text',
                ],
                [
                    'key' => 'invoice_footer',
                    'value' => 'Test Info',
                    'type' => 'text',
                ],
                
            ]
        );

    }
}
