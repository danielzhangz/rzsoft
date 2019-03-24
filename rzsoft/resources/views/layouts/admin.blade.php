<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv=X-UA-Compatible content=IE=EmulateIE11>
    {{--<script type="text/javascript" src="http://192.168.1.28:8000/CLodopfuncs.js?name=CLODOPA"></script>--}}

    <script type="text/javascript" src="http://zensz.com:8000/CLodopfuncs.js"></script>
   <script type="text/javascript" src="{{asset('resources/org/easyui/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/org/easyui/jquery.easyui.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/org/layer/layer.js')}}"></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/style/js/ch-ui.admin.js')}}"></script>

     <link rel="stylesheet" href="{{asset('resources/views/admin/style/font/css/font-awesome.min.css')}}">
    <link id="mytheme" rel="stylesheet" href="{{asset('resources/org/easyui/themes/default/easyui.css')}}">
    <link rel="stylesheet" href="{{asset('resources/org/easyui/themes/icon.css')}}">



    {{--<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">--}}
</head>
<body>
@yield('content')
</body>
</html>