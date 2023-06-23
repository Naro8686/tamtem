@extends('emails.blue_template', ['title' => 'Новая компания в Вашем портфеле agent.tamtem.ru', 'username' => $user->name])

@section('content')
    <p>{{$msg}}</p>
    <a href=" {{ url('/') }} "  style="color: #ffffff; display: block; padding: 10px 15px; border-radius: 32px; background-color: #2fc06e; font-family: Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 600; line-height: 15px; text-decoration: none;text-align: center; width: 200px; margin: 0 auto;">Перейти на сайт</a>
@endsection