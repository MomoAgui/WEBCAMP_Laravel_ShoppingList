@extends('admin.layout')

@section('contets')

        <menu label="リンク">
        <a href="/admin/top">管理画面Top</a><br>
        <a href="/admin/user/list">ユーザ一覧</a><br>
        <a href="/admin/logout">ログアウト</a><br>
        </menu>
    <h1>ユーザ一覧</h1><br>
    
     <table border="1">
            <tr>
                <th>ユーザーID
                <th>ユーザー名
                <th>購入した「買うもの」の数
        @foreach($users as $user)
            <tr>
                <th>{{ $user->id }}
                <th>{{ $user->name }}
                <th>{{ $user->shopping_lists_num }}
        @endforeach
           </table>
 @endsection
