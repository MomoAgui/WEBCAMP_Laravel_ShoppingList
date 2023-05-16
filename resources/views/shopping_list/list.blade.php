@extends('layout')

@section('contets')

<h1>「買うもの」登録</h1><br>

@if (session('front.shopping_list_list_success') == true)
                「買うもの」を登録しました！！<br>
            @endif
@if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
<form action="/shopping_list/list" method="post"><br>
@csrf
「買うもの」名:<input name="name"　value="{{old('name')}}"><br>
<button>「買うもの」を登録する</button>
</form>

<h1>「買うもの」一覧</h1>
 @if (session('front.list_delete_success') == true)
                リストから削除しました！！<br>
            @endif
<a href='/completed_shopping_list/list'>購入済み「買うもの」一覧</a>
<table border="1">
    <tr>
        <th>登録日
        <th>「買うもの」名
@foreach ($shopping_lists as $list)
        <tr>
            <td>{{ $list->created_at}}
            <td>{{ $list->name }}
            <td><form action="{{ route('complete',['shopping_list_id'=>$list->id]) }}" method="post">
             @csrf
            <button onclick='return confirm("このタスクを「完了」にします。よろしいですか？");' >完了</button></form>
            <td><form action="{{route('delete',['shopping_list_id'=>$list->id])}}" method="post">
                @csrf
                @method('DELETE')
                <button onclick="return confirm("このタスクを削除します。よろしいですか？");">削除</button>
            </form>
@endforeach



        </table>
        <!-- ページネーション -->
        {{-- {{ $shopping_lists->links() }} --}}
       現在{{ $shopping_lists->currentPage() }}ページ目<br>
       @if ($shopping_lists->onFirstPage() === false)
        <a href="/shopping_list/list">最初のページ</a>
        @else
        最初のページ
        @endif
        /
        @if ($shopping_lists->previousPageUrl() !== null)
            <a href="{{ $shopping_lists->previousPageUrl() }}">前に戻る</a>
        @else
            前に戻る
        @endif
        /
        @if ($shopping_lists->nextPageUrl() !== null)
            <a href="{{ $shopping_lists->nextPageUrl() }}">次に進む</a>
        @else
            次に進む
        @endif
        <br>
        <hr>
        <a href="/logout">ログアウト</a><br>

@endsection
