<?php

namespace Database\Seeders;

use App\Models\AppointmentType;
use Illuminate\Database\Seeder;

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
        $this->call([
            AcademicYearSeeder::class,
            UserSeeder::class,
            SemesterSeeder::class,
            DoorSeeder::class,
            ScheduleSeeder::class,

        ]);
    }
}
