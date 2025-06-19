<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */public function up(): void
{
    Schema::create('invoices', function (Blueprint $table) {
        $table->bigIncrements('id'); 

        $table->date('invoices_date')->nullable();
        $table->date('due_date')->nullable();
        $table->unsignedBigInteger('section_id')->unsigned();
        $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        $table->string('product');
        $table->string('status', 50);
        $table->integer('value_status');
        $table->string('discount');
        $table->decimal('Ammount_collection', 8, 2)->nullable();
        $table->decimal('Ammount_commission', 8, 2);
        $table->string('rat_vat');
        $table->decimal('value_vat', 8, 2);
        $table->decimal('total', 8, 2);
        $table->text('note')->nullable();
        $table->string('user');
        $table->date('payment_date')->nullable();
        $table->softDeletes();
        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
