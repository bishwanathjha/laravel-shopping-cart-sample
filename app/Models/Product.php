<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Products
 * @package App\Model
 */
class Product extends Base
{
    /** @todo implement softdelete */

    const TABLE = 'products';
    const PRIMARY_KEY = 'id';

    const ID = 'id';
    const UUID = 'uuid';
    const Title = 'title';
    const Description = 'description';
    const Category = 'category';
    const OriginalPrice = 'original_price';
    const ActualPrice = 'actual_price';
    const Image = 'image';
    const Quantity = 'quantity';
    const InStock = 'in_stock';
    const SellerName = 'seller_name';
}
