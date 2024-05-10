<x-app-layout>
    <x-slot name="breadcrumb">
        Room Management
    </x-slot>
    <div class="row g-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="sort" id="sort" class="form-select">
                                        <option value="default">Urutkan Berdasarkan</option>
                                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>
                                            Nama (A-Z)</option>
                                        <option value="name_desc"
                                            {{ request('sort') == 'name_desc' ? 'selected' : '' }}>
                                            Nama (Z-A)</option>
                                        <option value="property" {{ request('sort') == 'property' ? 'selected' : '' }}>
                                            Property</option>
                                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                                            Terbaru
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="filter" id="filter" class="form-select">
                                        <option value="all">Filter Hasil</option>
                                        <option value="active" {{ request('filter') == 'active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="inactive"
                                            {{ request('filter') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="recommended"
                                            {{ request('filter') == 'recommended' ? 'selected' : '' }}>Recommended Only
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('admin.rooms.index') }}" class="btn btn-warning">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Data Kamar</h5>
                    <a href="{{ route('admin.rooms.create') }}" class="btn btn-primary">
                        New Room Type
                    </a>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Property</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>Updated Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($rooms as $room)
                                <tr>
                                    <td>{{ $room->name }} &nbsp; {!! $room->is_recommended ? "<i class='bx bxs-star text-warning'></i>" : '' !!}</td>
                                    <td>{{ $room->property->name }}</td>
                                    <td>{{ $room->qty }} Unit</td>
                                    <td>
                                        @if ($room->status == 'active')
                                            <span class="badge bg-success">Active</span>
                                        @elseif ($room->status == 'inactive')
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $room->updated_at->format('d M Y, H:i') }}</td>
                                    <td>
                                        <span class="text-norap">
                                            <a href="{{ route('admin.rooms.edit', $room->id) }}"
                                                class="btn btn-sm btn-icon me-2">
                                                <i class="bx bx-edit text-warning"></i>
                                            </a>
                                            <button type="button" onclick="deleteRoom(this.dataset.url)"
                                                data-url="{{ route('admin.rooms.destroy', $room->id) }}"
                                                class="btn btn-sm btn-icon">
                                                <i class="bx bx-trash text-danger"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" align="center">
                                        Data not found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <form id="formDelete" action="">
                        @csrf

                    </form>
                </div>
                <div class="card-footer pb-0">
                    {{ $rooms->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    <form method="POST" id="deleteForm" action="">
        @csrf
        @method('DELETE')

    </form>
    @push('scripts')
        <script>
            function deleteRoom(url) {
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
</x-app-layout>
