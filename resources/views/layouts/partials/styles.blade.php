{!! seo() !!}
<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

<!-- Icons. Uncomment required icon fonts -->
<link rel="stylesheet" href="{{ asset('admin/fonts/boxicons.css') }}" />
<link rel="stylesheet" href="{{ asset('assets/css/custom-icons/css/custom-icons.css') }}">


<!-- Core CSS -->
<link rel="stylesheet" href="{{ asset('admin/css/core.css') }}" class="template-customizer-core-css" />
<link rel="stylesheet" href="{{ asset('admin/css/theme-default.css') }}" class="template-customizer-theme-css" />
<!--<link rel="stylesheet" href="../assets/css/demo.css" />-->
<!-- Vendors CSS -->
<link rel="stylesheet" href="{{ asset('admin/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />

<link rel="stylesheet" href="{{ asset('admin/libs/apex-charts/apex-charts.css') }}" />

<!-- Helpers -->
<script src="{{ asset('admin/js/helpers.js') }}"></script>

<!--datatable -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.css">

<!-- Filepond -->
<link rel="stylesheet" href="{{ asset('admin/libs/filepond/filepond.css') }}">
<link href="{{ asset('admin/libs/filepond/plugin/filepond-plugin-image-preview.css') }}" rel="stylesheet" />
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('admin/libs/select2/select2.css') }}">
<!-- Bootstrap Select -->
<link rel="stylesheet" href="{{ asset('admin/libs/bootstrap-select/bootstrap-select.css') }}">
<!-- Fancybox -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

<!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
<!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
<script src="{{ asset('admin/js/config.js') }}"></script>
@stack('styles')
