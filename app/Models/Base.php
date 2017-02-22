<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class Base extends Model
{
    const CreatedAt = 'created_at';
    const UpdatedAt = 'updated_at';

    public $perPage = 10;
}