<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>@{{ title }}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="{{ asset_cdn('assets/pc/dist/css/style.min.css') }}">
    </head>
    <body>
        <div ng-view></div>
        <script src="{{ asset_cdn('assets/pc/dist/js/common.min.js') }}"></script>
        <script src="{{ asset_cdn('assets/pc/dist/js/main.min.js') }}"></script>
        <script type="text/javascript">
            var baseUrl = "http://" + window.location.host + "/";
            var _token = '{{ csrf_token() }}';
            var resourceVersion = '{{ Config::get('app.static_version') }}';
        </script>
    </body>
</html>
