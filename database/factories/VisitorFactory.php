<?php


namespace Database\Factories;


use App\Models\Visitor;

use Illuminate\Database\Eloquent\Factories\Factory;


class VisitorFactory extends Factory

{

protected $model = Visitor::class;


public function definition()

{

return [

'name' => $this->faker->name(),

'comments' => $this->faker->realText(500)

];

}

}
