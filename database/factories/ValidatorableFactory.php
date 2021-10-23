<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Validator;
use App\Models\Validatorable;
use Illuminate\Database\Eloquent\Factories\Factory;

class ValidatorableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Validatorable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'validator_id' => Validator::factory(),
            'parent_id' => User::factory(),
            'parent_type' => (new User)->getMorphClass(),
            'mapped_readable_fields' => [],
            'mapped_updatable_fields' => [],
            'type' => null,
        ];
    }
}
