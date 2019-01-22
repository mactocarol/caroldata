<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table)  
        {
            $table->increments('id');  
            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('all_languages');
            $table->tinyInteger('is_default')->default(0)->comment('0-not default','1-default');
            $table->tinyInteger('is_active')->default(0)->comment('0-not active','1-active');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
