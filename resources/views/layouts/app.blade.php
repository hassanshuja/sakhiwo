<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{--CSRF Token--}}
        <meta name="csrf-token" content="{{ csrf_token() }}">
         <link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/bootstrap-datetimepicker.min.css')}}">
         <script type="text/javascript" src="{{asset('assets/admin/js/jquery.3.3.1.min.js')}}"></script>
         <script type="text/javascript" src="{{asset('assets/admin/js/jquery.tableTotal.js')}}"></script>
        <script type="text/javascript" src="{{asset('assets/admin/js/bootstrap-datetimepicker.min.js')}}"></script>
    


        {{--Title and Meta--}}
        @meta

        {{--Common App Styles--}}
        {{ Html::style(mix('assets/app/css/app.css')) }}

        {{--Styles--}}
        @yield('styles')

        {{--Head--}}
        @yield('head')

    </head>
    <body class="@yield('body_class')">

        {{--Page--}}
        @yield('page')

        {{--Common Scripts--}}
        {{ Html::script(mix('assets/app/js/app.js')) }}

        {{--Laravel Js Variables--}}
        @tojs

        {{--Scripts--}}
        @yield('scripts')
    </body>
</html>
