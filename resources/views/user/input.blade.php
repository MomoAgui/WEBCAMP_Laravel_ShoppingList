@extends('layout')

{{-- メインコンテンツ --}}
@section('contets')
        名前：{{ $datum['name'] }}<br>
        email：{{ $datum['email'] }}<br>
        パスワード：{{ $datum['password'] }}<br>
        パスワード（再度）:{{ $datum['password']}}<br>
@endsection