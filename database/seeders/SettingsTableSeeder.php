<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    
    /**
     * @var array
     */
    protected $settings = [
        [
            'key'   =>  'default_email_address',
            'value' =>  'admin@admin.com',
        ],
        [
            'key'   => 'phone_no',
            'value' => '+88017111111',
        ], 
        [
            'key'   => 'contact_address',
            'value' => 'Boalia Thana, Rajshahi',
        ],
    ];
    
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //looping through the $settings property and creating a new record for each record.
        foreach ($this->settings as $index => $setting)
        {
            $result = Setting::create($setting);
            if (!$result) {
                $this->command->info("Insert failed at record $index.");
                return;
            }
        }
        $this->command->info('Inserted '.count($this->settings). ' records');

    }
}
