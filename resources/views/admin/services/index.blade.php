<x-app-layout>
    <x-slot name="breadcrumb">
        Service Hotel
    </x-slot>

    <div class="row g-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Service Hotel</h5>
                    <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                        Service Baru
                    </a>
                </div>
                <div class="table-responsive table-nowrap">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Nama Service</th>
                            <th>Cover</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($services as $service)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $service->name }}
                                    </td>
                                    <td>
                                        <img src="{{ $service->getFirstMediaUrl('cover', 'thumb') }}" class="img-fluid" style="max-height: 70px" alt="">
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $service->status == 'active' ? 'success' : 'danger' }}">{{ $service->status }}</span>
                                    </td>
                                    <td>
                                        <span class="text-nowrap">
                                            <a href="{{ route('admin.services.edit', $service->id) }}"
                                                class="btn btn-sm btn-icon me-2">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <button data-url="{{ route('admin.services.destroy', $service->id) }}"
                                                onclick="deletePromo(this.dataset.url)" class="btn btn-sm btn-icon">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" align="center">
                                        Belum ada data, silahkan tambahkan data baru
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <form method="POST" id="deleteForm" action="">
                        @csrf
                        @method('DELETE')

                    </form>
                    @push('scripts')
                        <script>
                            function deletePromo(url) {
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $('#deleteForm').attr('action', url);
                                        $('#deleteForm').submit();
                                    }
                                })
                            }
                        </script>
                    @endpush
                </div>
                <div class="card-footer">
                    {{ $services->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
