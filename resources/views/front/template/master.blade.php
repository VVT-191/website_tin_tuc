
<!DOCTYPE html>
<html dir="ltr" lang="vi">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noodp,index,follow" />
    <meta name='revisit-after' content='1 days' />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')" />
    <meta name="keywords" content="@yield('keywords')" />
    <link rel="shortcut icon" type="image/x-icon" href="{{url('images/favicon/'.$favicon->Description)}}" />
    <link rel="canonical" href="@yield('url')" />    
    
    


    <link href="{{URL::asset('fontawesome-free-5.15.1/css/all.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('bootstrap-3.4.1/dist/css/bootstrap.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('css/style.css')}}" rel="stylesheet" />
    
    <script type="text/javascript">var url = "{!!url('/')!!}";</script> 

  </head>
  <body>

 
  <input type="hidden" id="_token" value="{{ csrf_token() }}">
   <div id="wrapper">
      @include('front.template.header')
      <div class="content">
      @yield('content')
      </div>
      @include('front.template.footer')
   </div>
     

  </body>
  <script src="{{URL::asset('js/jquery.js')}}"></script>
  <script src="{{URL::asset('bootstrap-3.4.1/dist/js/bootstrap.min.js')}}"></script> 
  
  <script src="{{URL::asset('js/front.js')}}"></script>  
  </html>