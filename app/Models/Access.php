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
