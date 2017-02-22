<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Order;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Order::TABLE, function (Blueprint $table) {
            $table->increments(Order::ID);
            $table->integer(Order::UserID)->nullable();
            $table->string(Order::Token)->nullable();;
            $table->integer(Order::ProductID);
            $table->string(Order::ProductName);
            $table->text(Order::ProductDesc);
            $table->float(Order::UnitPrice);
            $table->string(Order::Image);
            $table->integer(Order::Quantity);
            $table->smallInteger(Order::Status);
            $table->timestamp(Order::AddedAt)->nullable();
            $table->timestamp(Order::PurchasedAt)->nullable();
            $table->timestamps();

            $table->index(Order::UserID);
            $table->index(Order::Token);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Order::TABLE);
    }
}
