<?php

namespace Database\Factories;

use App\Models\ProjectTaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProjectTaskStatusFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProjectTaskStatus::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_id' => 0,
            'name' => 'New empty status',
            'color' => 'This is a new empty status',
            'closing' => false
        ];
    }
}
