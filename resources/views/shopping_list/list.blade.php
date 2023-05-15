@extends('layout')

@section('contets')
@if (session('front.shopping_list_register_success') == true)
                「買うもの」を登録しました！！<br>
            @endif
<h1>「買うもの」登録</h1><br>


<form action="/shopping_list/list" method="post"><br>
@csrf
「買うもの」名:<input name="name"><br>
<button>「買うもの」を登録する</button>
</form>

<h1>「買うもの」一覧</h1>
<a href='/completed_shopping_list/list'>購入済み「買うもの」一覧</a>
<table border="1">
    <tr>
        <th>登録日
        <th>「買うもの」名

        </table>

        <hr>
        <a href="/logout">ログアウト</a><br>

@endsection