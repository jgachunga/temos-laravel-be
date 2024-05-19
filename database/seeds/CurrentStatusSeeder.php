<?php

use App\Models\CurrentStatuses;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class CurrentStatusSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();
        CurrentStatuses::truncate();
        // Add the master administrator, user id of 1
        CurrentStatuses::create([
            'name' => 'In progress'
        ]);
        CurrentStatuses::create([
            'name' => 'In Transit'
        ]);
        CurrentStatuses::create([
            'name' => 'Offline'
        ]);
        CurrentStatuses::create([
            'name' => 'Online'
        ]);
        CurrentStatuses::create([
            'name' => 'Active'
        ]);
        CurrentStatuses::create([
            'name' => 'Started Outlet'
        ]);
        CurrentStatuses::create([
            'name' => 'Outlet marked as closed'
        ]);
        CurrentStatuses::create([
            'name' => 'Outlet data entry is cancelled'
        ]);
        CurrentStatuses::create([
            'name' => 'Other Reason'
        ]);
        CurrentStatuses::create([
            'name' => 'Completed outlet'
        ]);


        $this->enableForeignKeys();
    }
}
