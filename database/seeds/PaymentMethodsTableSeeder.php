<?php

use App\Models\PaymentMethods;
use Illuminate\Database\Seeder;

/**
 * Class UserTableSeeder.
 */
class PaymentMethodsTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seed.
     */
    public function run()
    {
        $this->disableForeignKeys();
        PaymentMethods::truncate();
        $paymentmethodsarr = [
            ["name" => "cash", "img_url" => "cash.jpg"],
            ["name" => "mpesa", "img_url" => "mpesa.jpg"],
            ["name" => "credit", "img_url" => "visa.png"],
        ];
        // Add the master administrator, user id of 1
        foreach($paymentmethodsarr as $method){
            PaymentMethods::create([
                'name' => $method['name'],
                'img_url' => $method['img_url'],
            ]);
        }

        $this->enableForeignKeys();
    }
}
