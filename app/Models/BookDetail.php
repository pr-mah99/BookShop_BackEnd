<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookDetail extends Model
{
    use HasFactory;

    
    // اسم الجدول في قاعدة البيانات
    protected $table = 'book_details';

    protected $primaryKey = 'id'; // اسم العمود الرئيسي

    protected $fillable = [       
        'book',     
        'version',
        'price',
        'bookState',
    ];

    // عمود المفتاح الخارجي للعلاقة
    protected $foreignKey = 'id';

    public function book()
    {
        return $this->belongsTo(Book::class, $this->foreignKey);
    }
}
