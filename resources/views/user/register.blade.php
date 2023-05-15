@extends('layout')


@section('title')@endsection

@section('contets')
<h1>ユーザー登録</h1>
 @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
        <form action="/user/register" method="post">
            @csrf
        名前：<input name="name"><br>
        email:<input name="email" type="email" value="{{ old('email')}}"><br>
        パスワード：<input name="password" type="password" ><br>
        パスワード（再度）:<input name="password_confirmation" type="password"><br>

        <button>登録する</button><br>
        </form>
@endsection
