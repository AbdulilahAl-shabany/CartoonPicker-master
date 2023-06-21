<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartoonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cartoons', function (Blueprint $table) {
            $table->id('cartoon_id');
            $table->string('cartoon_name');
            $table->double('Does not contain elements of violence')->default(0);
            $table->double('Creative')->default(0);
            $table->double('Educating')->default(0);
            $table->double('Entertain')->default(0);
            $table->double('No Pornographic Elements')->default(0);
            $table->string('cartoon_img')->default('images/noImage.jpg');
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
        Schema::dropIfExists('cartoons');
    }
}
