<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        /* Styles para centralizar o formulário */
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Figtree', ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
        }
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 14px 34px 0px rgba(0, 0, 0, 0.08);
            background-color: #fff;
        }
        .form-container input,
        .form-container button {
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="form-container">
    <ul style="list-style-type:decimal">
        <li><a href="{{route('report.consumer')}}" style="text-decoration: none">Requisições por consumidor</a></li>
        <li><a href="{{route('report.service')}}" style="text-decoration: none">Requisições por serviço</a></li>
        <li><a href="{{route('report.latency')}}" style="text-decoration: none">Tempo médio de request , proxy e gateway por serviço</a></li>
    </ul>
</div>
</body>
</html>
