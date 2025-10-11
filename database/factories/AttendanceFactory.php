<?php

namespace Database\Factories;

use App\Models\Attendance;
use App\Models\ClassRoom;
use App\Models\Lesson;
use App\Models\School;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    protected $model = Attendance::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'school_id' => School::factory(),
            'student_id' => Student::factory(),
            'class_id' => ClassRoom::factory(),
            'lesson_id' => Lesson::factory(),
            'status' => $this->faker->randomElement(['present', 'absent', 'late']),
            'attendance_by_user_id' => User::factory(),
            'attended_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'description' => $this->faker->optional(0.3)->sentence(),
        ];
    }

    /**
     * Indicate that the attendance is present.
     */
    public function present(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'present',
        ]);
    }

    /**
     * Indicate that the attendance is absent.
     */
    public function absent(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'absent',
        ]);
    }

    /**
     * Indicate that the attendance is late.
     */
    public function late(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'late',
        ]);
    }
}
