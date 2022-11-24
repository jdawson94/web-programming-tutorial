<?php


namespace Database\Factories;


use App\Models\Visitor;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\Factory;


class VisitorFactory extends Factory

{

protected $model = Visitor::class;


public function definition()

{

return [

'user_id' => User::factory(1)->create()->first(),

'comments' => $this->faker->realText(500)

];

}

}
