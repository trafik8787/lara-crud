<?php

namespace Trafik8787\LaraCrud\Seeder;

use Faker\Generator;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Database\Seeder;

/**
 * Class CategoryTableExampleSeeder
 * @package Trafik8787\LaraCrud\Seeder
 */
class CategoryTableExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Factory $factory, Generator $faker)
    {

        $factory->define(\App\Http\Node\Model\CategoryExampleModel::class, function () use ($faker) {

            return [
                'url' => $faker->domainWord,
                'title' => $faker->text($maxNbChars = 20),
                'description' => $faker->text($maxNbChars = 50),
                'name' => $faker->jobTitle
            ];


        });

        factory(\App\Http\Node\Model\CategoryExampleModel::class, 10)->create();


    }
}
