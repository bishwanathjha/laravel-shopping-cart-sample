<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use App\Models\Product;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Product::TABLE, function (Blueprint $table) {
            $table->increments(Product::PRIMARY_KEY);
            $table->string(Product::UUID, 60);
            $table->string(Product::Title);
            $table->text(Product::Description);
            $table->string(Product::Category);
            $table->float(Product::OriginalPrice);
            $table->float(Product::ActualPrice);
            $table->string(Product::Image);
            $table->integer(Product::Quantity);
            $table->smallInteger(Product::InStock);
            $table->string(Product::SellerName);
            $table->timestamps();

            // Creating index
            $table->index(Product::Title);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Product::TABLE);
    }
}
