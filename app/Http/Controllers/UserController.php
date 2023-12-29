<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    // Display all users
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    // Display the user
    public function show($id)
    {
        // Find the user
        $user = User::findOrfail($id);

        // Checking access rights for library
        $access = User::join('accesses', 'accesses.id_giver', '=', 'users.id')
            ->where('id_recipient', $user->id)
            ->where('id_giver', auth()->user()->id)
            ->where("deleted_at", null)
            ->exists();
        $text_access_button = "Разрешить";
        if ($access) {
            $text_access_button = "Запретить";
        }

        // Books user, if user the access
        $books = User::join('accesses', 'accesses.id_giver', '=', 'users.id')
            ->join('books', 'books.id_owner', '=', 'users.id')
            ->where('id_recipient', auth()->user()->id)
            ->where('id_giver', $id)
            ->where("accesses.deleted_at", null)
            ->get();
        return view('user.show', compact('user', 'text_access_button', 'books'));
    }
}
