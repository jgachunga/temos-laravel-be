<?php

use App\Models\SkipOption;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class SkipOptionsSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();
        SkipOption::truncate();
        // Add the master administrator, user id of 1
        SkipOption::create([
            'condition' => 'was answered'
        ]);
        SkipOption::create([
            'condition' => 'not answered'
        ]);

        $this->enableForeignKeys();
    }
}
