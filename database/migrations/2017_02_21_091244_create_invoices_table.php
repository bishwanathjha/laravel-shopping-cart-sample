<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Invoice;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Invoice::TABLE, function (Blueprint $table) {
            $table->increments(Invoice::ID);
            $table->string(Invoice::UUID, 60);
            $table->integer(Invoice::ProductQty);
            $table->string(Invoice::OrderIDs);
            $table->text(Invoice::TotalPrice);
            $table->float(Invoice::PaymentType);
            $table->string(Invoice::IsPaid);
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
        Schema::dropIfExists('invoices');
    }
}
