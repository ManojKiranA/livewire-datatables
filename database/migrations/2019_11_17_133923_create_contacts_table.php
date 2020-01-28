<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('favorite_color')->nullable();
            $table->string('last_contacted_at')->nullable();

            $table->timestamps();
        });
    }
}
