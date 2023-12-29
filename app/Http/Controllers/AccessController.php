<?php

namespace App\Http\Controllers;

use App\Models\Access;
use Illuminate\View\View;

class AccessController extends Controller
{

    // Display all users which give the access
    public function users()
    {
        $users = Access::join('users', 'users.id', '=', 'id_giver')
            ->where('id_recipient', auth()->user()->id)
            ->where("deleted_at", null)
            ->get();
        return view('user.index', compact('users'));
    }

    // Changing access to library
    public function change($id_recipient)
    {
        // Checking record access
        $record = Access::where("id_recipient", $id_recipient)
            ->where("id_giver", auth()->user()->id)
            ->where("deleted_at", null)
            ->first();

        // Delete or create the access
        if ($record) {
            $record->delete();
        } else {
            Access::create([
                "id_recipient" => $id_recipient,
                "id_giver" => auth()->user()->id,
            ]);
        }

        return redirect()->route("user.show", $id_recipient);
    }
}
