<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemReviewImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_review_images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('review_id')->nullable();
            $table->string('image_path')->nullable();
            $table->string('compressed_image_path')->nullable();
            $table->string('thumbs_image_path')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('item_review_images');
    }
}
