<?php

namespace Database\Factories;

use App\Enum\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;


class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->text(10),
            'description' => fake()->text(),
            'due_date' => fake()->date(),
            'status' => $this->faker->randomElement(TaskStatus::cases())->value,
        ];
    }
}
