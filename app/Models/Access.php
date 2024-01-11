<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Access extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "accesses";
    protected $guarded = [];

    // Function for Display all users which give the access
    public function users()
    {
        $users = Access::where('id_recipient', auth()->user()->id)
            ->whereNull('deleted_at')
            ->with('userGiver')
            ->get();
        return $users;
    }

    // Function for Checking record access
    public function checkRecord($id_recipient)
    {
        $record = Access::where("id_recipient", $id_recipient)
            ->where("id_giver", auth()->user()->id)
            ->where("deleted_at", null)
            ->first();
        return $record;
    }

    // Relationsheeps
    public function userGiver(): BelongsTo
    {
        return $this->belongsTo(User::class, "id_giver");
    }
    public function userRecipient(): BelongsTo
    {
        return $this->belongsTo(User::class, "id_recipient");
    }
}
