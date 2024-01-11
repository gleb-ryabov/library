<?php

namespace App\Http\Middleware;

use App\Models\Book;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBookAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $bookId = $request->route('id');
        $book = Book::findOrFail($bookId);
        $isOwner = 0;
        $accessLibrary = false;

        if (auth()->check()) {
            // Checking whether the user is the owner
            if ($book->id_owner == auth()->user()->id) {
                $isOwner = 1;
            }

            // Checking the access to the library
            $accessLibrary = Book::where('id', $bookId)
                ->whereHas('user', function ($query) {
                    $query->whereHas('access', function ($query) {
                        $query->where('id_recipient', auth()->user()->id)
                            ->whereNull('deleted_at');
                    });
                })->exists();

        }

        // Checking access rights
        if (($book->link_access == 1) || $isOwner || $accessLibrary) {
            return $next($request);
        } else {
            abort(404);
        }
    }

}
