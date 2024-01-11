<?php

namespace App\Http\Controllers;

use App\Models\Access;
use Illuminate\View\View;

class AccessController extends Controller
{

    // Display all users which give the access
    public function users()
    {
        $accessModel = new Access();
        $users = $accessModel->users();

        return view('user.index', compact('users'));
    }

    // Changing access to library
    public function change($id_recipient)
    {
        $accessModel = new Access();
        // Checking record access
        $record = $accessModel->checkRecord($id_recipient);

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
