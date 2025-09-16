<?php

namespace Database\Factories;

use App\Models\Sms;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sms>
 */
class SmsFactory extends Factory
{
    protected $model = Sms::class;

    public function definition(): array
    {
        return [
            'sms' => $this->faker->sentence,
            'secret_key' => $this->faker->uuid,
        ];
    }
}
