<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $payments_types = ['credit_card','cash_on_delivery','bank_transfer'];
        $faker = Faker::create();

        foreach ($payments_types as $type){
            $details = [];

            if ($type === 'credit_card'){
                $details = [
                    'holder_name' => $faker->name,
                    'number'  => $faker->creditCardNumber(),
                    'cvv'=> $faker->randomNumber(3),
                    'expire_date'=>$faker->creditCardExpirationDateString()
                ];

            }

            if ($type === 'cash_on_delivery'){
                $details = [
                    'first_name' => $faker->firstName(),
                    'last_name'  => $faker->lastName(),
                    'address'    => $faker->address()
                ];
            }

            if ($type === 'bank_transfer'){
                $details = [
                    'swift' => $faker->swiftBicNumber(),
                    'iban'  => $faker->iban(),
                    'name'   => $faker->name()
                ];
            }

            Payment::create([
                'type' => $type,
                'details' => $details
            ]);

        }
    }
}
