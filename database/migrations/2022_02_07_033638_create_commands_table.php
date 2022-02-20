<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("commands", function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("collection_id");
            $table->string("description", 150)->nullable();
            $table->string("command", 150)->index();
            $table
                ->foreign("collection_id")
                ->references("id")
                ->on("collections");
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
        Schema::dropIfExists("commands");
    }
}
