<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_places', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('city', 100);
            $table->string('street', 30);
            $table->string('house_number', 5);
            $table->string('apartment_number', 5);
            $table->string('zip_code', 10);
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_places');
    }
}
