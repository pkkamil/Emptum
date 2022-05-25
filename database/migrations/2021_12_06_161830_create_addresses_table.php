<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['person', 'company']);
            $table->string('name', 100);
            $table->string('surname', 100);
            $table->string('company_name', 100)->nullable();
            $table->string('nip_code', 15)->nullable();
            $table->string('telephone', 15)->nullable();
            $table->string('street', 100);
            $table->string('house_number', 10);
            $table->string('apartment_number', 10)->nullable();
            $table->string('zip_code', 10);
            $table->string('city', 100);
            $table->integer('user_id');
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
        Schema::dropIfExists('addresses');
    }
}
