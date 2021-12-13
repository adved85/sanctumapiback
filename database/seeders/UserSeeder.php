<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

use App\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $usersJson = File::get("database/seeders/data/users_mock.json");
        $usersObject = json_decode($usersJson);

        foreach ($usersObject as $item) {
            $user = User::create([
                'first_name' => $item->first_name,
                'last_name' => $item->last_name,
                'password' => $item->password,
                'email' =>$item->email
            ]);
            $user->assignRole($item->role);
        }
    }
}
