<?php

use Illuminate\Database\Seeder;
use App\Models\Privileges;

class PrivilegesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $row = Privileges::Create(
            [  
                'name' => 'Базовый', 
                'point' => 0,
                'duration_months' => 12,
                'procent' => 8,
            ]
        );

        $row = Privileges::Create(
            [  
                'name' => 'Бронзовый', 
                'point' => 500,
                'duration_months' => 12,
                'procent' => 10,
            ]
        );

        $row = Privileges::Create(
            [  
                'name' => 'Серебряный', 
                'point' => 5000,
                'duration_months' => 18,
                'procent' => 10,
            ]
        );
  
        $row = Privileges::Create(
            [  
                'name' => 'Золотой', 
                'point' => 15000,
                'duration_months' => 18,
                'procent' => 15,
            ]
        );

        $row = Privileges::Create(
            [  
                'name' => 'Платиновый', 
                'point' => 50000,
                'duration_months' => 24,
                'procent' => 20,
            ]
        );
    }
}