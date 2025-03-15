<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();

        $data = [
            [
                'display_name' => 'Company Name',
                'key' => 'company_name',
                'value' => 'Premio'
            ],
            [
                'display_name' => 'Company Email',
                'key' => 'company_email',
                'value' => 'admin@admin.com'
            ],
            [
                'display_name' => 'Set Timezone',
                'key' => 'set_timezone',
                'value' => config('app.timezone')
            ],
            [
                'display_name' => 'Phone',
                'key' => 'phone',
                'value' => '01764908494'
            ],
            [
                'display_name' => 'Address',
                'key' => 'address',
                'value' => 'Bangladesh/Dhaka'
            ]
        ];

        Setting::insert($data);
    }
}
