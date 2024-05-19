<?php

use App\Models\FormStatus;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class StatusSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();
        FormStatus::truncate();
        // Add the master administrator, user id of 1
        FormStatus::create([
            'status' => 'Started'
        ]);
        FormStatus::create([
            'status' => 'In Progress'
        ]);
        FormStatus::create([
            'status' => 'Completed'
        ]);
        FormStatus::create([
            'status' => 'Cancelled'
        ]);

        $this->enableForeignKeys();
    }
}
