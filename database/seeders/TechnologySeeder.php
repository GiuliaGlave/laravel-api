<?php

namespace Database\Seeders;

use App\Models\Technology;
use Faker\Generator as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
       $labels = ['HTML', 'CSS', 'Javascript', 'PHP', 'Laravel', 'Bootstrap', 'Vue.js', 'Vite', 'Tailwind', 'MySQL'];

        foreach($labels as $label) {
            $technolgy = new Technology();
            $technolgy->label = $label;
            $technolgy->color = $faker->hexColor();

            $technolgy->save();
        }
    }
}