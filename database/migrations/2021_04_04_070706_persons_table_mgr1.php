<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//credits:
//          https://laravel.com/docs/8.x/migrations
//          https://www.techiediaries.com/laravel-8-crud-tutorial/

class PersonsTableMgr1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('persons', function (Blueprint $table) {
          $table->id();
          $table->string('name', 800);
          $table->timestamps();
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons');
    }
}
