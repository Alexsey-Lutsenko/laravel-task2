<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call([
        //     AdminSeeder::class
        // ]);
        Role::insert([
            ['role' => 'admin'],
            ['role' => 'user']
        ]);

        Status::insert([
            ['status' => 'В процессе'],
            ['status' => 'Завершено']
        ]);
    }
}
