<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Новая книга') }}
        </h2>
    </x-slot>

    <div class = "body">
        <div class = "form_book">
            <form action = "{{route('book.store')}}" method="POST">
                @csrf
                <input type = "text" name = "name" placeholder="Название">
                <textarea name = "text" placeholder="Начните писать..."></textarea>
                <div class = "form_button">
                    <button type = "submit">Создать</button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
