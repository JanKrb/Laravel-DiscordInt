<?php

namespace Database\Factories;

use App\Models\ProjectTaskStatusAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectTaskStatusAssignmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectTaskStatusAssignment::class;

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
            'status_id' => 0
        ];
    }
}
