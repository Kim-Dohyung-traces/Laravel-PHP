<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()   //시더가 실행되면 작동할 코드 작성
    {
        // App\User::create(
        //     [   //sprintf(형식 문자열, 인수리스트): 형식문자열에 지정한 형태로 
        //         //                                문자열을 생성해서 반환하는 메서드
        //         //str_random(인자) : 인자값 갯수만큼의 길이의 문자열을 랜덤 생성
        //         //                   도우미 함수 = 6.0, 5.8, 5.7버전에는 없음

        //         //현재 사용하는 버전에 없으니
        //         //23번째줄을 Str::random(3). ' '. Str::random(4)로 변경가능
        //         // 'name' => Str::random(3) . ' ' . Str::random(4),
        //         // 'email' => Str::random(10) . '@test.com',
        //         // 'password' => bcrypt('password'),


        //     ]
        // );

        //-------------------------------------------------------------------------------------------
        //p94 
        //User모델에 5개를 추가
        factory(App\User::class, 5)->create();
    }
}