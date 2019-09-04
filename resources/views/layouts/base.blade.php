<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name', 'Laravel')}}</title>

    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <style>
        body {
            background: #FFF8F0;
            color: #1E1E24;
        }
        a:hover {
            text-decoration: none;
        }
    </style>
</head>
<body>
<div id="app">
    @yield('content')
</div>
<input type="hidden" value="@auth() {{ auth()->user()->api_token }} @endauth" id="api_token">
<script src="{{mix('js/app.js')}}"></script>
</body>
</html>
