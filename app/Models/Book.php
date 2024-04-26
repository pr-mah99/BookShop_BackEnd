<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    // اسم الجدول في قاعدة البيانات
    protected $table = 'book';

    protected $primaryKey = 'bookId'; // اسم العمود الرئيسي

    
    protected $fillable = [
        'title',
        'author',
        'genre',
        'price',
        'availability',       
    ];

    public $timestamps = true; // تمكين إنشاء الحقول created_at و updated_at تلقائيًا

    protected $dates = ['createdAt', 'updatedAt'];
}
