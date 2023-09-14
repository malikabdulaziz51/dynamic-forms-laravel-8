<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("master_berita", function (Blueprint $table) {
            $table->id();
            $table->integer("author_id")->nullable();
            $table->integer("category_id")->nullable();
            $table->string("judul")->nullable();
            $table->string("slug")->nullable();
            $table->text("konten")->nullable();
            $table->string("thumbnail")->nullable();
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
        Schema::dropIfExists("users");
    }
};
