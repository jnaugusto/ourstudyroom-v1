<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserRoleTableSeeder::class);
        $this->call(CourseTableSeeder::class);
        $this->call(LevelTableSeeder::class);
    }
}

class UserRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_roles')->delete();
        DB::table('user_roles')->insert([
            [
                'role_id' => 1,
                'role_name' => 'Administrator',
            ],
            [
                'role_id' => 2,
                'role_name' => 'Academics',
            ],
            [
                'role_id' => 3,
                'role_name' => 'Teacher',
            ],
            [
                'role_id' => 4,
                'role_name' => 'Student',
            ],
            [
                'role_id' => 5,
                'role_name' => 'Agent',
            ],
        ]);
    }
}

class CourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->delete();
        DB::table('courses')->insert([
            [
                'course_name' => 'Flexkids',
                'age_range' => '1-12',
            ],
            [
                'course_name' => 'Flexteens',
                'age_range' => '13-19',
            ],
            [
                'course_name' => 'Practical English',
                'age_range' => '20-255',
            ],
            [
                'course_name' => 'Conversational English',
                'age_range' => '0-255',
            ],
            [
                'course_name' => 'Travel English',
                'age_range' => '0-255',
            ],
            [
                'course_name' => 'Current English',
                'age_range' => '0-255',
            ],
        ]);
    }
}

class LevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->delete();

        // Flexkids
        DB::table('levels')->insert([
            [
                'course_id' => 1,
                'level_name' => 'FK3',
                'num_session' => 72,
            ],
            [
                'course_id' => 1,
                'level_name' => 'FK4',
                'num_session' => 72,
            ],
            [
                'course_id' => 1,
                'level_name' => 'FK5',
                'num_session' => 72,
            ],
            [
                'course_id' => 1,
                'level_name' => 'FK6',
                'num_session' => 72,
            ],
        ]);

        // Flexteens
        DB::table('levels')->insert([
            [
                'course_id' => 2,
                'level_name' => 'FT1',
                'num_session' => 72,
            ],
            [
                'course_id' => 2,
                'level_name' => 'FT2',
                'num_session' => 72,
            ],
            [
                'course_id' => 2,
                'level_name' => 'FT3',
                'num_session' => 72,
            ],
            [
                'course_id' => 2,
                'level_name' => 'FT4',
                'num_session' => 72,
            ],
            [
                'course_id' => 2,
                'level_name' => 'FT5',
                'num_session' => 72,
            ],
            [
                'course_id' => 2,
                'level_name' => 'FT6',
                'num_session' => 72,
            ],
        ]);

        // Practical English
        DB::table('levels')->insert([
            [
                'course_id' => 3,
                'level_name' => 'PE1',
                'num_session' => 72,
            ],
            [
                'course_id' => 3,
                'level_name' => 'PE2',
                'num_session' => 72,
            ],
            [
                'course_id' => 3,
                'level_name' => 'PE3',
                'num_session' => 72,
            ],
            [
                'course_id' => 3,
                'level_name' => 'PE4',
                'num_session' => 72,
            ],
            [
                'course_id' => 3,
                'level_name' => 'PE5',
                'num_session' => 72,
            ],
            [
                'course_id' => 3,
                'level_name' => 'PE6',
                'num_session' => 72,
            ],
        ]);

        // Conversational English
        DB::table('levels')->insert([
            [
                'course_id' => 4,
                'level_name' => 'CE1',
                'num_session' => 72,
            ],
            [
                'course_id' => 4,
                'level_name' => 'CE2',
                'num_session' => 72,
            ],
            [
                'course_id' => 4,
                'level_name' => 'CE3',
                'num_session' => 72,
            ],
            [
                'course_id' => 4,
                'level_name' => 'CE4',
                'num_session' => 72,
            ],
            [
                'course_id' => 4,
                'level_name' => 'CE5',
                'num_session' => 72,
            ],
            [
                'course_id' => 4,
                'level_name' => 'CE6',
                'num_session' => 72,
            ],
        ]);

        // Travel English English
        DB::table('levels')->insert([
            [
                'course_id' => 5,
                'level_name' => 'TE1',
                'num_session' => 72,
            ],
            [
                'course_id' => 5,
                'level_name' => 'TE2',
                'num_session' => 72,
            ],
            [
                'course_id' => 5,
                'level_name' => 'TE3',
                'num_session' => 72,
            ],
            [
                'course_id' => 5,
                'level_name' => 'TE4',
                'num_session' => 72,
            ],
            [
                'course_id' => 5,
                'level_name' => 'TE5',
                'num_session' => 72,
            ],
            [
                'course_id' => 5,
                'level_name' => 'TE6',
                'num_session' => 72,
            ],
        ]);

        // Current English
        DB::table('levels')->insert([
            [
                'course_id' => 6,
                'level_name' => 'CE0',
                'num_session' => 72,
            ],
        ]);
    }
}