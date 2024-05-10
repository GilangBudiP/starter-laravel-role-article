<!-- Sweet Alert -->
<link rel="stylesheet" href="{{ asset('admin/libs/sweetalert/sweetalert2.css') }}">
</link>
<script src="{{ asset('admin/libs/sweetalert/sweetalert2.js') }}"></script>
<script>
    @if (session()->has('success'))
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Ok'
        });
    @endif
    @if (session()->has('error'))
        Swal.fire({
            title: 'Error!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'Ok'
        });
    @endif
    @if (session()->has('warning'))
        Swal.fire({
            title: 'Warning!',
            text: "{{ session('warning') }}",
            icon: 'warning',
            confirmButtonText: 'Ok'
        });
    @endif
</script>
