<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelateGroupsToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_user', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('group_id')
                ->comment('The Group ID');
            $table->unsignedInteger('user_id')
                ->comment('The User ID');
            $table->boolean('can_manage')
                ->default(false)
                ->comment('Can this user manage the group?');
            $table->timestamps();

            $table->foreign('group_id')->references('id')->on('groups');
            $table->foreign('user_id')->references('id')->on('users');
            $table->index('can_manage');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_user');
    }
}
