<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Faker\Factory as Faker;

class BannerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => Str::uuid(),
            'title' => Faker::create()->sentence,
            'image' => Faker::create()->url,
            'ordinal_no' => 1,
            'start_datetime' => Carbon::now(),
            'end_datetime' => Carbon::now(),
            'is_active' => 1
        ];
    }
}
