<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{

    protected $table = "users";

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Function for get user's books, if user have the access
    public function getBooks($id)
    {
        $books = User::whereHas('accessGiver', function (Builder $query) use ($id) {
            $query->where('id_recipient', '=', auth()->user()->id)
                ->where('id_giver', '=', $id)
                ->whereNull('deleted_at');
        })
            ->with('booksUser')
            ->get();
        return $books;
    }
    // Function for checking access rights for library
    public function checkAccess($user)
    {
        $access = User::whereHas('accessGiver', function (Builder $query) use ($user) {
            $query->where('id_giver', '=', auth()->user()->id)
                ->where('id_recipient', '=', $user->id)
                ->whereNull('deleted_at');
        })
            ->exists();
        return $access;
    }

    // Relationsheeps
    public function booksUser(): HasMany
    {
        return $this->hasMany(Book::class, 'id_owner');
    }
    public function access(): HasMany
    {
        return $this->hasMany(Access::class, 'id_recipient');
    }
    public function accessGiver(): HasMany
    {
        return $this->hasMany(Access::class, 'id_giver');
    }
}
