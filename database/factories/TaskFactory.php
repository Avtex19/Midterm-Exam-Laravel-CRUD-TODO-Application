<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    private const TITLE_PREFIXES = [
        'Finish',
        'Prepare',
        'Review',
        'Update',
        'Draft',
        'Plan',
        'Organize',
        'Call',
        'Clean',
        'Submit',
    ];

    private const TITLE_OBJECTS = [
        'project proposal',
        'meeting notes',
        'weekly report',
        'client feedback',
        'database backup',
        'shopping list',
        'team schedule',
        'documentation',
        'invoice details',
        'presentation slides',
    ];

    private const ENGLISH_DESCRIPTIONS = [
        'Complete this task before the end of the day and share progress with the team.',
        'Double-check all details and make sure the final version is easy to understand.',
        'Coordinate with teammates, then update this item once every step is finished.',
        'Focus on the high-priority parts first and leave clear notes for follow-up.',
        'Use this task to track progress and close it after verifying the expected result.',
        'Collect required information, validate it, and document the outcome clearly.',
        'Break this work into small steps and finish each one in order.',
        'Review the current status, fix pending issues, and mark as done when complete.',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement([Task::STATUS_PENDING, Task::STATUS_DONE]);
        $deadline = fake()->optional()->dateTimeBetween('-1 month', '+2 months');

        return [
            'title' => fake()->randomElement(self::TITLE_PREFIXES) . ' ' . fake()->randomElement(self::TITLE_OBJECTS),
            'description' => fake()->optional(0.8)->randomElement(self::ENGLISH_DESCRIPTIONS),
            'status' => $status,
            'deadline' => $deadline ? $deadline->format('Y-m-d') : null,
        ];
    }
}

