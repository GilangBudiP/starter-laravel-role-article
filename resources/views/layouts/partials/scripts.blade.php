<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('admin/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('admin/libs/popper/popper.js') }}"></script>
<script src="{{ asset('admin/js/bootstrap.js') }}"></script>
<script src="{{ asset('admin/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('admin/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('admin/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('admin/js/main.js') }}"></script>

<!--Cleave-->
<script src="{{ asset('admin/libs/cleave/cleave.js') }}"></script>

<!-- Ckeditor -->
<script src="{{ asset('admin/libs/ckeditor/ckeditor.js') }}"></script>

<!-- Filepond -->
<script src="{{ asset('admin/libs/filepond/filepond.js') }}"></script>
<script src="{{ asset('admin/libs/filepond/plugin/filepond-plugin-image-preview.js') }}"></script>
<script src="{{ asset('admin/libs/filepond/plugin/filepond-plugin-file-validate-size.js') }}"></script>
<script src="{{ asset('admin/libs/filepond/plugin/filepond-plugin-image-exif-orientation.js') }}"></script>
<script src="{{ asset('admin/libs/filepond/plugin/filepond-plugin-file-validate-type.js') }}"></script>
{{-- <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script> --}}

<!-- Datatable -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.js"></script>


<!-- Select2 -->
<script src="{{ asset('admin/libs/select2/select2.js') }}"></script>
<!-- Bootstrap Select -->
<script src="{{ asset('admin/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<!-- Masonry -->
<script src="https://cdn.jsdelivr.net/npm/masonry-layout@4.2.2/dist/masonry.pkgd.min.js"
    integrity="sha384-GNFwBvfVxBkLMJpYMOABq3c+d3KnQxudP/mGPkzpZSTYykLBNsZEnG2D9G/X/+7D" crossorigin="anonymous" async>
</script>
<script src="{{ asset('admin/js/dashboards-analytics.js') }}"></script>

<!-- Place this tag in your head or just before your close body tag. -->
{{-- <script async defer src="https://buttons.github.io/buttons.js"></script> --}}

<!-- Library -->
<!-- SweetAlert Script -->
@include('layouts.partials.alerts')


@stack('scripts')
