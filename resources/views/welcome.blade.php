<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Scolarité - Gestion des frais</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="{{ asset("dist/css/app.css") }}" />
    </head>
    <body>
        <div id="app"></div>
    <!-- BEGIN: JS Assets-->
   {{-- <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>--}}
    <script src="{{ asset("dist/js/app.js") }}"></script>
    <script src="{{ asset("js/app.js") }}"></script>
        <script src="{{ asset("js/feather-icons.js") }}"></script>
        <script>
            feather.replace();
        </script>
    <!-- END: JS Assets-->
    </body>
</html>
