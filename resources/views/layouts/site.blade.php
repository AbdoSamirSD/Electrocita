<!DOCTYPE html>
<html lang="en">
    @include('site.includes.head')

    <body>
        <div class="container-scroller">
            @include('site.includes.header')
            @yield('content')
            @include('site.includes.footer')
        </div>
        @include('site.includes.scripts')
    </body>
</html>