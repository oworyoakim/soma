<?php

namespace App\Traits;

use App\Models\Question;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

trait FakeData
{
    use WithFaker;
    protected function roleData()
    {
        $name = $this->faker->unique()->userName;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }

    protected function userData()
    {
        $password = $this->faker->password;
        return [
            'firstName' => $this->faker->firstName,
            'lastName' => $this->faker->lastName,
            'username' => $this->faker->unique()->userName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $password,
            'cpassword' => $password,
        ];
    }

    protected function courseData()
    {
        $title = $this->faker->sentence;
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'code' => $this->faker->randomNumber(5),
            'description' => $this->faker->paragraph,
            'duration' => random_int(10,60),
            'weight' => random_int(2,5),
            'image' => $this->faker->imageUrl(),
        ];
    }
    protected function questionData()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'moduleId' => random_int(1,1000),
            'weight' => random_int(2,5),
            'type' => $this->faker->randomElement([Question::TYPE_REVISION,Question::TYPE_EXAM,Question::TYPE_BOTH]),
        ];
    }

    protected function moduleData()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'courseId' => random_int(1,1000),
            'duration' => $this->faker->randomElement([10,15,20,25,30,35,40,45,50,55,60,65,70,75,80,85,90,95,100]),
            'outline' => $this->faker->paragraph(5),
        ];
    }

    protected function answerData()
    {
        return [
            'title' => $this->faker->sentence,
            'questionId' => random_int(1,1000),
            'correct' => $this->faker->randomElement([true,false]),
        ];
    }

    protected function topicData()
    {
        return [
            'moduleId' => random_int(1,1000),
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph(5),
            'body' => $this->faker->paragraph(20),
        ];
    }
}
