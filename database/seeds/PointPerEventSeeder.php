<?php

use Illuminate\Database\Seeder;
use App\Models\PointPerEvent;
class PointPerEventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        PointPerEvent::query()->truncate();
        
        $row = PointPerEvent::Create(
            [  
                'event_name' => 'bid_buy', 
                'point' => 2,
            ]
        );

        $row = PointPerEvent::Create(
            [  
                'event_name' => 'set_winner', 
                'point' => 100,
            ]
        );

        $row = PointPerEvent::Create(
            [  
                'event_name' => 'response', 
                'point' => 10,
            ]
        );

        $row = PointPerEvent::Create(
            [  
                'event_name' => 'points_from_agents_to_agent', 
                'point' => 30,
            ]
        );

        $row = PointPerEvent::Create(
            [  
                'event_name' => 'points_from_agents_to_registered_agent', 
                'point' => 100,
            ]
        );
    }
}
