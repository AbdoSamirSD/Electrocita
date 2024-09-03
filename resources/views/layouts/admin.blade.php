<!DOCTYPE html>
<html lang="en">
  @include('admin.includes.head')
  <body>
    <div class="container-scroller">
      @include('admin.includes.sidebar')
      <div class="container-fluid page-body-wrapper">
        @include('admin.includes.header')
        <div class="main-panel">
          <div class="content-wrapper">
            @yield('content')
          </div>
          @include('admin.includes.footer')
        </div>
      </div>
    </div>
    @include('admin.includes.scripts')

  </body>
</html>