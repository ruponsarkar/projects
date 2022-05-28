<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>School</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">

        <!-- Styles -->

        <link rel="stylesheet" href="{{asset('css/app.css')}}">


        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- <link rel="stylesheet" href="{{asset('css/collected/all.min.css')}}"> -->

        <link rel="stylesheet" href="{{asset('css/collected/adminlte.min.css')}}">

    
    </head>
    <body class="hold-transition sidebar-mini layout-fixed">
        <div class="wrapper">
            <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
            </div>
            <div class="row">
                <div class="col-md-12" id="app">
                    <router-view></router-view>
                    <!-- <Students /> -->
                </div>
            </div>
        </div>





        <!-- <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
              <b>Version</b> 3.2.0
            </div>
          </footer> -->

     <script src="{{asset('js/app.js')}}"></script>
     <!-- jQuery -->
<script src="{{asset('js/collected/jquery.min.js')}}"></script>

<script src="{{asset('js/collected/adminlte.js')}}"></script>
    </body>
</html>
