<?php

namespace App\Models;

/**
 * Class Invoices
 * @package App\Model
 */
class Invoice extends Base
{
    const TABLE = 'invoices';
    const PRIMARY_KEY = 'id';

    const ID = 'id';
    const UUID = 'uuid';
    const ProductQty = 'product_qty';
    const OrderIDs = 'order_ids';
    const TotalPrice = 'total_price';
    const PaymentType = 'payment_type';
    const IsPaid = 'is_paid';
}
