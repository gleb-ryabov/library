<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Список книг') }}
        </h2>
    </x-slot>

    <div class = "body">

        <!-- Button for creating the book -->
        <div class = "new_book_btn">
            <form action = "{{route('book.create')}}">
                <button type = "submit">Создать новую книгу</button>
            </form>
        </div>

        <!-- List of books -->
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                @foreach ($books as $book)
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <a href = "{{route('book.show', $book->id)}}">
                            <div class="max-w-xl">
                                {{$book->name}}
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
