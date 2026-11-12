<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('shipping_status_id');
            $table->unsignedBigInteger('payment_status_id');


            $table->integer('total_payment');
            $table->integer('total_weight');
            $table->integer('shipment_fee');
            $table->string('shipment_receipt')->nullable();
            $table->string('recipient_address');
            $table->string('recipient');
            $table->string('recipient_number');
            $table->string('province');
            $table->string('district');
            $table->string('postal_code');
            $table->string('courier');
            $table->string('service');
            $table->string('etd');
            $table->string('notes')->nullable();
            $table->string('code');
            $table->string('payment_url')->nullable();
            
            $table->foreign('shipping_status_id')->references('id')->on('shipping_statuses');
            $table->foreign('payment_status_id')->references('id')->on('payment_statuses');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('purchases');
    }
}
