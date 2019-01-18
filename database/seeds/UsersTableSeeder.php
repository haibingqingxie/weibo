<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = factory(User::class)->times(50)->make();
        User::insert($users->makevisible(['password', 'remember_token'])->toArray());

        $user = user::find(1);
        $user->name = 'Jason Li';
        $user->email = 'jasonli@seasidecrab.com';
        $user->save();
    }
}
