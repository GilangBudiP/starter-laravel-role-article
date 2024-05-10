<x-app-layout>

    <x-slot name="breadcrumb">
        Property
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex justify-content-between align-content-center">
                        List Property
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Nama</td>
                                    <td>Subdomain</td>
                                    <td>Status</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($properties as $property)
                                    <tr>
                                        <td>{{ $property->name }}</td>
                                        <td>{{ $property->subdomain }}</td>
                                        <td>
                                            @if ($property->status == true)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-nowrap">
                                                <a class="ul-link-action text-warning"
                                                    href="{{ route('admin.properties.edit', $property->id) }}"
                                                    data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="bx bx-edit"></i></a>
                                                {{-- <button onclick="deleteArticle(this.dataset.url)" data-url=""
                                                    class="btn btn-sm btn-icon text-danger delete-record"
                                                    data-toggle="tooltip" data-placement="top" title="Hapus">
                                                    <i class="bx bx-trash"></i>
                                                </button> --}}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">
                                            Data not found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <link rel="stylesheet" href="{{ asset('admin/libs/sweetalert/sweetalert2.css') }}">
        </link>
        <script src="{{ asset('admin/libs/sweetalert/sweetalert2.js') }}"></script>
        <script>
            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'Ok'
                })
            @endif
        </script>
    @endpush
</x-app-layout>
