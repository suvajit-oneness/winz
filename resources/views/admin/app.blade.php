<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title') - {{ config('app.name') }}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/main.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/font-awesome/4.7.0/css/font-awesome.min.css') }}"/>
    @yield('styles')
    @stack('styles')
</head>
<body class="app sidebar-mini rtl">
    @include('admin.partials.header')
    @include('admin.partials.sidebar')
    <main class="app-content" id="app">
        @yield('content')
    </main>
    <script src="{{ asset('backend/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('backend/js/popper.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/js/main.js') }}"></script>
    <script src="{{ asset('backend/js/plugins/pace.min.js') }}"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.5/tinymce.min.js"></script> --}}
    
    <script type="text/javascript">
        jQuery( "#page_type" ).on('change',function() {
          if(this.value == 'Categories'){
            $('#category_type select').removeAttr('disabled');
            $('#category_type').show();
            $('#country select').attr('disabled', 'disabled');
            $('#country').hide();
          }else if(this.value == 'Location'){
            $('#country select').removeAttr('disabled');
            $('#country').show();
            $('#category_type select').attr('disabled', 'disabled');
            $('#category_type').hide();
          }
          else{
            $('#category_type select').attr('disabled', 'disabled');
            $('#category_type').hide();
            $('#country select').attr('disabled', 'disabled');
            $('#country').hide();
          }
        });

        function isNumberKey(event){
            if(event.charCode >= 48 && event.charCode <= 57){
                return true;
            }
            return false;
        }
    </script>
    @stack('scripts')
</body>
</html>