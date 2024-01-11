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
        return view('user.all', compact('users'));
    }

    // Display the user
    public function show($id)
    {
        $userModel = new User();
        // Find the user
        $user = User::findOrfail($id);

        // Checking access rights for library
        $access = $userModel->checkAccess($user);

        $text_access_button = "Разрешить";
        if ($access) {
            $text_access_button = "Запретить";
        }

        // User's books
        $books = $userModel->getBooks($id);

        return view('user.show', compact('user', 'text_access_button', 'books'));
    }
}
