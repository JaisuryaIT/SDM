<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentDetails>
 */
class StudentDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = $this->faker->firstName();
        $year = $this->faker->randomElement(['I', 'II', 'III', 'IV']);
        $course = $this->faker->randomElement(['B.E', 'B.Tech']);
        $department = $this->faker->randomElement(['AE', 'AG', 'AD', 'AL', 'AU', 'BM', 'BT', 'CE', 'CB', 'CD', 'CS', 'CT', 'EE', 'EC', 'EI', 'FT', 'FD', 'IS', 'IT', 'ME', 'MC', 'TT']);
        $last_three_digits = $this->faker->numberBetween(101, 350);
        $roll_no = '7376' . ($year == 'IV' ? '20' : ($year == 'III' ? '21' : ($year == 'II' ? '22' : '23'))) . ($course == 'B.E' ? '1' : '2') . $department . str_pad($last_three_digits, 3, '0', STR_PAD_LEFT);
        $seat_category = $this->faker->biasedNumberBetween(0, 99, 'sqrt') < 60 ? 'Management' : ($this->faker->biasedNumberBetween(0, 99, 'sqrt') < 90 ? 'Government Normal' : 'Government Special');
        $quota = ($seat_category == 'Management' ? 'Management' : ($seat_category == 'Government Normal' ? $this->faker->randomElement(['Community Quota', 'Sports Quota']) : $this->faker->randomElement(['Special 7.5% Quota', 'Physically Challenged Quota'])));
        $email = strtolower($firstName) . '.' . strtolower($department) . ($year == 'IV' ? '20' : ($year == 'III' ? '21' : ($year == 'II' ? '22' : '23'))) . '@bitsathy.ac.in';
        return [
            'name' => $firstName,
            'email' => $email,
            'roll_no' => $roll_no,
            'department' => $department,
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'year' => $year,
            'status' => $this->faker->biasedNumberBetween(0, 9, 'sqrt') < 9 ? 'Active' : 'Inactive',
            'accommodation' => $this->faker->randomElement(['Hosteller', 'Dayscholar']),
            'community' => $this->faker->randomElement(['SC', 'ST', 'BC', 'BCM', 'MBC', 'DC']),
            'quota' => $quota,
            'seat_category' => $seat_category,
            'course' => $course,
            'religion' => $this->faker->randomElement(['Hindu', 'Muslim', 'Christian']),
            'residency_status' => $this->faker->biasedNumberBetween(0, 9, 'sqrt') < 9 ? 'India' : 'Other',
            'blood_group' => $this->faker->randomElement(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-']),
            'date_of_admission' => $this->faker->dateTimeThisYear(),
        ];
    }
}
