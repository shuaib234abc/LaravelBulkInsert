<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

//credits:
//          https://laravel.com/docs/8.x/migrations
//          https://www.techiediaries.com/laravel-8-crud-tutorial/

class UploadedDatasetFileMgr1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('uploaded_dataset_files', function (Blueprint $table) {
          $table->id();
          $table->string('filename', 120);
          $table->bigInteger('lines_complete');
          $table->integer('all_completed');
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
        Schema::dropIfExists('uploaded_dataset_files');
    }
}
