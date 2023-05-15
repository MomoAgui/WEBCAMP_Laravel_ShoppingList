@extends('layout')

@section('contets')

@section('title')(購入済み「買うもの」一覧)@endsection

<h1>購入済み「買うもの」一覧</h1>

<a href="/shopping_list/list">「買うもの」一覧に戻る</a><br>

<table border="1">
    <tr>
        <th>「買うもの」名
        <th>購入日
         @foreach ($copmleted_shopping_lists as $list)
        <tr>
            <td>{{ $list->name}}
            <td>{{ $list->created_at }}

@endforeach

        </table>
        <!-- ページネーション -->
        {{-- {{ $completed_shopping_lists->links() }} --}}
       現在{{ $completed_shopping_lists->currentPage() }}ページ目<br>
       @if ($completed_shopping_lists->onFirstPage() === false)
        <a href="/completed_shopping_list/list">最初のページ</a>
        @else
        最初のページ
        @endif
        /
        @if ($completed_shopping_lists->previousPageUrl() !== null)
            <a href="{{ $completed_shopping_lists->previousPageUrl() }}">前に戻る</a>
        @else
            前に戻る
        @endif
        /
        @if ($completed_shopping_lists->nextPageUrl() !== null)
            <a href="{{ $completed_shopping_lists->nextPageUrl() }}">次に進む</a>
        @else
            次に進む
        @endif
        <br>

        </table>

        <hr>
        <a href="/logout">ログアウト</a><br>

@endsection
