<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактирование книги') }}
        </h2>
    </x-slot>

    <div class = "body">
        <div class = "form_book">
            <form action = "{{route('book.update', $book->id)}}" method = "POST">
                @csrf
                @method('patch')
                <input type = "text" name = "name" value="{{$book->name}}">
                <textarea name = "text">{{$book->text}}</textarea>
                <div class = "form_button">
                    <button type = "submit">Сохранить</button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
