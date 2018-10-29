<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('callables', function (Blueprint $table) {
            $table->unsignedInteger('phone_number_id')
                ->comment('The phone number ID');
            $table->unsignedInteger('callable_id')
                ->comment('The ID of the model that has the phone number');
            $table->string('callable_type')
                ->comment('The model type');
            $table->timestamps();

            $table->foreign('phone_number_id')->references('id')->on('phone_numbers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('callables');
    }
}
