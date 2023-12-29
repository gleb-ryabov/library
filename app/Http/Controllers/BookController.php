<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BookController extends Controller
{

    // Display user's books
    public function index()
    {
        $books = Book::where("id_owner", auth()->user()->id)->get();
        return view("book.index", compact("books"));
    }

    // Display the book
    public function show($id)
    {
        $book = Book::findOrFail($id);

        $is_owner = 0;
        $access_library = false;
        if (auth()->check()) {

            // checking whether the user is the owner
            if ($book->id_owner == auth()->user()->id) {
                $is_owner = 1;
            }

            // checking the having to the library
            $access_library = Book::join('users', 'users.id', '=', 'id_owner')
                ->join('accesses', 'accesses.id_giver', '=', 'users.id')
                ->where('books.id', $id)
                ->where('id_recipient', auth()->user()->id)
                ->where("accesses.deleted_at", null)
                ->exists();
        }

        // checking access rights
        if (($book->link_access == 1) || $is_owner || $access_library) {
            return view("book.show", compact("book", "is_owner"));
        } else {
            abort(404);
        }
    }

    // Form for creating the book
    public function create()
    {
        return view("book.create");
    }
    // Create the book
    public function store()
    {
        $data = request()->validate([
            "name" => "string",
            "text" => "string",
        ]);
        $data += [
            'id_owner' => auth()->user()->id,
            'link_access' => 0,
        ];
        Book::create($data);
        return redirect()->route("book.index");
    }

    // Form for editing the book
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view("book.edit", compact("book"));
    }
    // Update the book
    public function update($id)
    {
        $book = Book::findOrFail($id);
        $data = request()->validate([
            "name" => "string",
            "text" => "string",
        ]);
        $book->update($data);
        return redirect()->route("book.show", $book->id);
    }

    // Delete the book
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return redirect()->route("book.index");
    }

    // Share the book
    public function share($id)
    {
        $book = Book::findOrFail($id);
        $new_status_share = ["link_access" => 1];
        if ($book->link_access == 1) {
            $new_status_share = ["link_access" => 0];
        }
        $book->update($new_status_share);
        return redirect()->route("book.show", $book->id);
    }
}
