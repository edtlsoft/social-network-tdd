<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <form action="{{ route('statuses.store')  }}" method="post">
            @csrf
            <textarea name="body" id="body" cols="30" rows="10"></textarea>
            <button id="create-status">Post status</button>
        </form>
    </body>
</html>
