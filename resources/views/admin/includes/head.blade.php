<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
      body {
          background-color: #0a0a0a; /* Darker background */
          color: #d0d0d0;
        }
        .form-section {
            background-color: #121212; /* Even darker form section */
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input,
        .form-group select {
            background-color: #2b2b2b; /* Even darker input and select background */
            color: #d0d0d0;
            border: 1px solid #4a4a4a; /* Slightly lighter border */
        }
        .form-group input:focus,
        .form-group select:focus {
            border-color: #007bff; /* Highlight color for focus */
            box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
        }
        .alert {
            margin-bottom: 20px;
            color: #fff;
        }
        .alert-success {
            background-color: #1c6d34; /* Darker success color */
        }
        .alert-danger {
            background-color: #a32a2a; /* Darker error color */
        }
        .btn-custom {
            margin-right: 10px;
        }
        .nav-pills .nav-link {
            background-color: #2b2b2b; /* Darker nav pill background */
            color: #d0d0d0;
        }
        .nav-pills .nav-link.active {
            background-color: #007bff; /* Highlight color for active tab */
            color: #fff;
        }
        .tab-content {
            background-color: #121212; /* Even darker tab content */
            border-radius: 8px;
            padding: 20px;
        }
        .img-thumbnail {
            margin-bottom: 2px; /* Space between image and form */
        }
        /* New styling for full-width columns with 1px gap */
        .form-column {
            width: calc(50% - 0.5px); /* Width of columns, adjusted for gap */
            margin-right: 1px; /* 1px gap between columns */
            float: left; /* Ensure columns are side by side */
        }
        .form-column:last-child {
            margin-right: 0; /* Remove margin for the last column */
        }
        
        
        /* Style for Firefox */
        .table-responsive {
            scrollbar-width: thin; /* Make the scrollbar thinner */
            scrollbar-color: #333 #ffffff; /* Scrollbar color and track color */
        }
        
        .table-responsive::-moz-scrollbar {
            width: 8px; /* Set the width of the scrollbar */
        }
        
        .table-responsive::-moz-scrollbar-track {
            background: #f1f1f1; /* Track color */
        }
        
        .table-responsive::-moz-scrollbar-thumb {
            background: #333; /* Scrollbar color */
            border-radius: 10px; /* Round the corners */
        }
        
        .table-responsive::-moz-scrollbar-thumb:hover {
            background: #555; /* Darker color on hover */
        }
        
        </style>
    
    
    
    
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css">    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/vendors/jvectormap/jquery-jvectormap.css">
    <link rel="stylesheet" href="/assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="/assets/vendors/owl-carousel-2/owl.carousel.min.css">
    <link rel="stylesheet" href="/assets/vendors/owl-carousel-2/owl.theme.default.min.css">
    
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/images/favicon.png">
    <style type="text/css">/* Chart.js */
@keyframes chartjs-render-animation{from{opacity:.99}to{opacity:1}}.chartjs-render-monitor{animation:chartjs-render-animation 1ms}.chartjs-size-monitor,.chartjs-size-monitor-expand,.chartjs-size-monitor-shrink{position:absolute;direction:ltr;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1}.chartjs-size-monitor-expand>div{position:absolute;width:1000000px;height:1000000px;left:0;top:0}.chartjs-size-monitor-shrink>div{position:absolute;width:200%;height:200%;left:0;top:0}
</style>
@livewireStyles
@stack('styles')
</head>