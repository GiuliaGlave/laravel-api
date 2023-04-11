<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

use App\Models\Project;
use Faker\Generator as Faker;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 50; $i++){
            $project = new Project;
            $project->titile = $faker-> catchPhrase();
            $project->slug = Str::of($project->title)->slug('-');
            $project->thumbnail = $faker->imageUrl(640, 480, 'homepage', true);
            $project->details = $faker->paragraph(15);

            $project-> save();

        }

    }
}