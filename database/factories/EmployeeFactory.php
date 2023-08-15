<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
use Faker\Generator as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    protected $model = Employee::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        return [
            'name' => $this->faker->name,
            'role' => 'Receptionist',
            'status' => true,
            'shift' => rand(1, 3),
            'day_off' => $this->faker->date('Y-m-d'),
            'salary' => $this->faker->randomNumber(5),
        ];
    }
}
