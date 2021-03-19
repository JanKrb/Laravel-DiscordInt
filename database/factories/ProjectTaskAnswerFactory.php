<?php

namespace Database\Factories;

use App\Models\ProjectTaskAnswer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectTaskAnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectTaskAnswer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_id' => 0,
            'task_id' => 0,
            'description' => 'New empty comment',
            'user_id' => 0,
        ];
    }
}
