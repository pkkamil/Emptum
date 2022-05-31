<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->integer('user_id')->nullable();
            $table->string('email', 100);
            $table->enum('status', ['ordered', 'accepted', 'sent', 'delivered', 'cancelled'])->default('ordered');
            $table->decimal('total', 10, 2);
            $table->integer('cart_id');
            $table->enum('delivery_method', ['pickup_in_person', 'courier']);
            $table->integer('deliveryPlace_id')->nullable();
            $table->enum('payment_method', ['cash_on_delivery']);
            $table->enum('purchaser_type', ['person', 'company']);
            $table->string('name', 100);
            $table->string('surname', 100);
            $table->string('company_name', 100)->nullable();
            $table->string('nip_code', 10)->nullable();
            $table->string('telephone', 15)->nullable();
            $table->string('street', 100);
            $table->string('house_number', 5);
            $table->string('apartment_number', 5)->nullable();
            $table->string('zip_code', 10);
            $table->string('city', 50);
            $table->string('comment', 500);
            $table->decimal('delivery_price', 10, 2)->default('0.00');
            $table->timestamp('ordered_at')->useCurrent();
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
        Schema::dropIfExists('orders');
    }
}
