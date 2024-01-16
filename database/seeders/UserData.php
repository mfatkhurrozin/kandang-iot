<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserData extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Pemilik',
                'username' =>'pemilik',
                'password' =>bcrypt('123456'),
                'level'=>1,
                'email'=> 'pemilik@kandangku.com'
            ],
            [
                'name' => 'Karyawan',
                'username' =>'karyawan',
                'password' =>bcrypt('123456'),
                'level'=>2,
                'email'=> 'karyawan@kandangku.com'
            ]
        ];

        foreach($user as $key => $value){
            User::create($value);
        }
    }
}
