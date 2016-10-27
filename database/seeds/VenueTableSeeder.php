<?php

use Illuminate\Database\Seeder;

class VenueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Venue::class, 50)->create()->each(function($u) {
            $u->location()->save(factory(App\Location::class)->make());
        });

    }
}
