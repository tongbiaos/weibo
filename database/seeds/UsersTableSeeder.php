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
        $users = factory(user::class)->times(50)->make();
        User::insert($users->makeVisible(['password','remember_token'])->toArray());
        //获取数据库的第一个数据并修改
        $user = User::find(1);
        $user->name = 'tongbiaos';
        $user->email = 'tongbiaos@163.com';
        $user->password = bcrypt('123456');
        $user->is_admin = true;
        $user->save();
    }
}
