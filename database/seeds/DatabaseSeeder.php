<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Seed the application's database.
     */
    public function run()
    {
        Model::unguard();

        $this->truncateMultiple([
            'cache',
            'failed_jobs',
            'ledgers',
            'jobs',
            'sessions',
        ]);

        // $this->call(AuthTableSeeder::class);
        // $this->call(PaymentMethodsTableSeeder::class);
        // $this->call(StructureTableSeeder::class);
        // $this->call(StatusSeeder::class);
        // $this->call(StructureTableSeeder::class);
        // $this->call(CurrentStatusSeeder::class);
        // $this->call(ClockTypesSeeder::class);
        // $this->call(UomSeeder::class);
        $this->call(QuestionTypesSeeder::class);
        $this->call(SkipOptionsSeeder::class);

        Model::reguard();
    }
}
