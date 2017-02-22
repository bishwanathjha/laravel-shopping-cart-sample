<?php

namespace App\Models;

/**
 * Class Orders
 * @package App\Model
 */
class Order extends Base
{
    const TABLE = 'orders';
    const PRIMARY_KEY = 'id';

    const ID = 'id';
    const UserID = 'user_id';
    const Token = 'token';
    const ProductID = 'product_id';
    const ProductName = 'product_name';
    const ProductDesc = 'product_desc';
    const UnitPrice = 'unit_price';
    const Image = 'image';
    const Quantity = 'quantity';
    const Status = 'status';
    const AddedAt = 'added_at';
    const PurchasedAt = 'purchased_at';

    const STATUS_ADDED_TO_CART = 1;
    const STATUS_ORDER_PLACED = 2;
    const STATUS_ORDER_SHIPPED = 3;

    /**
     * @param int $status
     * @return bool
     */
    static public function IsValidStatus($status) {
        return in_array($status, [self::STATUS_ADDED_TO_CART, self::STATUS_ORDER_PLACED, self::STATUS_ORDER_SHIPPED]);
    }
}
