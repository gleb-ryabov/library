<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}
        </h2>
    </x-slot>

    <div class = "body">
        <div class = "access_button">
            <form action = "{{route('access.change', $user->id)}}" method = "POST">
                @csrf
                <button action = "submit">{{$text_access_button}} доступ к моей библиотеке</button>
            </form>
        </div>

        @if ($books->count() != 0)

            <div class = "library_open">Книги пользователя</div>
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    @foreach ($books as $book)
                        @foreach ($book->booksUser as $info_book)
                            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                                <a href="{{route('book.show', $info_book['id'])}}">
                                    <div class="max-w-xl">
                                        {{$info_book['name']}}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>

        @else
            <div class = "library_hidden">
                Библиотека пользователя {{ $user->name }} скрыта
            </div>
        @endif
    </div>

</x-app-layout>
