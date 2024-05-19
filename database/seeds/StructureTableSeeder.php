<?php

use App\Models\SaleStructure;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class StructureTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();
        SaleStructure::truncate();
        // Add the master administrator, user id of 1
        SaleStructure::create([
            'title' => 'Temos',
            'parent_id' => 0,
        ]);

        $this->enableForeignKeys();
    }
}
