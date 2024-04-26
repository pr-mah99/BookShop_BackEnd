<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index(Request $request)
     {
         $perPage = $request->input('limit', 10);
         $page = $request->input('page', 1);
         $searchTerm = $request->input('search');
         $availability = $request->input('availability'); // استخراج التوفر من الطلب
     
         $query = Book::query();
     
         if ($searchTerm) {
             $query->where(function($query) use ($searchTerm) {
                 $query->whereRaw("CONCAT(title, genre, author) LIKE ?", '%' . $searchTerm . '%');
             });
         }
     
         if ($availability !== null) {
             $query->where('availability', $availability); // تصفية بحسب التوفر
         }
     
         $books = $query->latest('created_at')->paginate($perPage, ['*'], 'page', $page);
     
         return response()->json($books);
     }
     
     

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'genre' => 'required|string|max:255',
            'price' => 'required|numeric',
            'availability' => 'required|boolean',
        ]);
    
        $book = Book::create($request->all());
        return response()->json($book, 201);
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'string|max:255',
            'author' => 'string|max:255',
            'genre' => 'string|max:255',
            'price' => 'numeric',
            'availability' => 'boolean',
        ]);
    
        $book->update($request->all());        
        return response()->json(['message' => 'تم تعديل الكتاب بنجاح'], 200);
        
    }
    

    public function destroy($id)
    {
        // ابحث عن الكتاب المطلوب حذفه
        $book = Book::findOrFail($id);

        // قم بحذف الكتاب
        $book->delete();

        // استجابة بنجاح
        return response()->json(['message' => 'تم حذف الكتاب بنجاح'], 200);
    }

    public function getAuthorsWithBookCount(Request $request)
    {
        // استخراج اسم المؤلف وعدد الكتب لديه
        $authorsWithBookCount = Book::select('author', DB::raw('COUNT(*) as book_count'))
            ->groupBy('author')
            ->get();

        // تحويل النتيجة إلى JSON
        return response()->json($authorsWithBookCount);
    }
}
