<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()    //up == 만든다의 의미
    {
        Schema::create('authors', function (Blueprint $table) {
            //table: Blueprint 클래스의 인스턴스
            //       authors테이블 객체(인스턴스)
            $table->bigIncrements('id');  // 6.x버전 미만은 Increments임
            $table->string('email', 255);
            $table->string('password', 60);
            $table->timestamps();   //create_at, updated_at 필드를 생성해줌
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()  //down = 테이블 삭제
    {
        Schema::dropIfExists('authors');
    }
}
