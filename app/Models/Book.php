<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "books";
    protected $guarded = [];

    // Function for getting user's books
    public function books()
    {
        $books = Book::where("id_owner", auth()->user()->id)->get();
        return $books;
    }

    // Relationsheeps
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, "id_owner");
    }
}
