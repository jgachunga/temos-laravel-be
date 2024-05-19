<?php

use App\Models\ClockTypes;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class ClockTypesSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();
        ClockTypes::truncate();
        // Add the master administrator, user id of 1
        ClockTypes::create([
            'name' => 'Clock In'
        ]);
        ClockTypes::create([
            'name' => 'Clock Out'
        ]);
        $this->enableForeignKeys();
    }
}
