<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/semantic.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/fullcalendar.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom-scroll.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/flag.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">

    </head>
    <body>
        <div class="flex-center position-ref full-height" id="application">
            <div class="content">
                <div class="title m-b-md">
                    Date and Time
                </div>
                <clock></clock>
            </div>
        </div>

        <script src="{{ asset('js/plugins/jquery.min.js') }}"></script>
        <script src="{{ asset('js/plugins/jstz.min.js') }}"></script>
        <script src="{{ asset('js/plugins/moment.min.js') }}"></script>
        <script src="{{ asset('js/plugins/moment-timezone.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
