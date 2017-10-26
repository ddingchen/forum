<?php

use App\Reply;
use App\User;
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
        factory(User::class)->create([
            'name' => 'dc',
            'email' => 'dc@dc.com',
            'password' => bcrypt('123456'),
        ]);

        factory(User::class)->create([
            'name' => 'sj',
            'email' => 'sj@sj.com',
            'password' => bcrypt('123456'),
        ]);

        factory(Reply::class, 10)->create();
    }
}
