<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * @return void
     */
    public function up()
    {
        Schema::create("menus", function (Blueprint $table) {

            $table->string("menuable_type");
            $table->string("menuable_id");

            $table->string("category")->nullable(true);
            $table->string("icon");
            $table->string("title");
            $table->text("description");

            $table->primary([ "menuable_type", "menuable_id", ]);
        });
    }

    /**
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists("menus");
    }
};
