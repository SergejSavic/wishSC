<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{__('sendcloud::pages.title')}}</title>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{\SendCloud\MiddlewareComponents\Utility\Asset::getAssetUrl('css/sendcloud.css')}}">
</head>
<body>
<img class="sc-logo"
     src="{{\SendCloud\MiddlewareComponents\Utility\Asset::getAssetUrl('img/sendcloud_with_name.svg')}}">

<div class="sc-container">
    <div class="sc-content-window-wrapper">
        <div class="sc-content-window">
            <img class="sc-welcome-icon" src="{{\SendCloud\MiddlewareComponents\Utility\Asset::getAssetUrl('img/sendcloud.svg')}}">
            @yield('sc-error-title-section')
            <div class="sc-dashboard-text-wrapper sc-main-text">
                {{$exception->getMessage()}}
            </div>
        </div>
    </div>
</div>
</body>
</html>
