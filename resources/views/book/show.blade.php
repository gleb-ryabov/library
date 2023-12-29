@extends('layouts.book')

@section('content')
<div class = "book">
    <!-- Managing a book if the user is the owner -->
    @if ($is_owner)
        <div class = "manage_book">

            <!-- Deletion the book -->
            <form action = "{{route('book.delete', $book->id)}}" method = "POST">
                @csrf
                @method('delete')
                <button type = "submit" class = "delete_btn">Удалить</button>
            </form>

            <!-- Edition the book -->
            <form action="{{route('book.edit', $book->id)}}" method = "GET">
                <button type = "submit" class = "edit_btn">Редактировать</button>
            </form>

            <!-- Charing the book -->
            <form action="{{route('book.share', $book->id)}}" method="POST">
                @csrf
                @php
                    $button_label = "Поделиться";
                    if ($book->link_access == 1)
                    {
                        $button_label = "Не делиться";
                    }
                @endphp
                <button type="submit" class = "share_btn">{{$button_label}}</button>
            </form>

            <!-- The link to the page, if it is open -->
            @if ($book->link_access == 1)
                <div class = "link_access">
                    <p>Страница доступна по ссылке: {{"http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']}}</p>
                </div>
            @endif

        </div>
    @endif

    <!-- Book's name -->
    <div class = "name">
        {{$book->name}}
    </div>
    <!-- Book's text -->
    <div class = "text">
        {{$book->text}}
    </div>
</div>
@stop
