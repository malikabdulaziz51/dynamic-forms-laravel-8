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
        Schema::create("berita_tag", function (Blueprint $table) {
            $table->id();
            $table
                ->foreignId("id_berita")
                ->constrained("master_berita")
                ->onDelete("cascade");
            $table
                ->foreignId("id_tag")
                ->constrained("tag")
                ->onDelete("cascade");
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
        Schema::dropIfExists("berita_tag");
    }
};
