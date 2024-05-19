<?php

use App\Models\PaymentMethods;
use App\Models\Uom;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class UomSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();
        Uom::truncate();
        $uomsarr = [
            ["name" => "piece"],
            ["name" => "dozen"],
            ["name" => "carton"],
        ];
        // Add the master administrator, user id of 1
        foreach($uomsarr as $uom){
            Uom::create([
                'name' => $uom['name'],
            ]);
        }

        $this->enableForeignKeys();
    }
}
