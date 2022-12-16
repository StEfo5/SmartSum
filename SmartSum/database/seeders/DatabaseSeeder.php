<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\EducationClass;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $class_names = ['ГУМ51', 'БХ51', "ПТХ51", "РН51", "ИНЖ51", "ФМ51", 'ГУМ52', 'БХ52', "ПТХ52", "РН52", "ИНЖ52", "ФМ52"];
        foreach($class_names as $class_name){
            $class = new EducationClass();
            $class->name = $class_name;
            $class->save();
        } 
    }
}
