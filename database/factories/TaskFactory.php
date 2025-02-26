<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->text(10),
            'description' => fake()->text(),
            'due_date' => fake()->date(),
            'status' => 'completed',
        ];
    }
}
