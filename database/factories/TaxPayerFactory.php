<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\TaxPayer;
use Faker\Generator as Faker;

$factory->define(TaxPayer::class, function (Faker $faker) {
    return [
        //
        'official_name' => 'FEDERAL MINISTRY OF FINANCE',
        'official_rin' => 'GOV14221',
        'business_name' => 'FEDERAL MINISTRY OF FINANCE',
        'business_rin' => 'FOR14221',
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        
        'payer_rin' => 'IND' . $faker->numberBetween(01234567, 44444444),
        'payer_name' => $faker->unique()->name,
        'start_month' => $faker->monthName('January'),
        'end_month' => $faker->monthName(),
        'gross_pay' => $faker->randomFloat(2, 19999999, 499999999),
        'consolidated_relief_allowance' => $faker->randomFloat(2, 19999999, 79999999),
        'pension_contribution_declared' => $faker->randomFloat(2, 1999999, 79999999),
        'nhf_contribution_declared' => 0,
        'nhis_contribution_declared' => $faker->randomFloat(2, 1999999, 7999999),
        'tax_free_pay' => $faker->randomFloat(2, 19999999, 79999999),
        'chargeable_income' => $faker->randomFloat(2, 1999999, 79999999),
        'tax_payable' => $faker->randomFloat(2, 19999, 799999),
        'annual_tax' => $faker->randomFloat(2, 199999, 79999999),
    ];
});
