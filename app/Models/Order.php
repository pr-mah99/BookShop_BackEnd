<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $primaryKey = 'order_id';

    protected $fillable = [
        'user_id',
        'orderType',
        'items',
        'location',
        'payment',
        'customerNotes',
        'total',
        'state'
    ];

    protected $casts = [
        'items' => 'json',
        'state' => 'boolean',
    ];
  
    public $timestamps = true; // تمكين إنشاء الحقول created_at و updated_at تلقائيًا

    protected $dates = ['createdAt', 'updatedAt'];
}
