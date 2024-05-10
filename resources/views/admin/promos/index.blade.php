<x-app-layout>
    <x-slot name="breadcrumb">
        Data Promo
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
                                            {{ request('filter') == 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="main" {{ request('filter') == 'main' ? 'selected' : '' }}>
                                            Inactive</option>
                                        <option value="recommended"
                                            {{ request('filter') == 'recommended' ? 'selected' : '' }}>Web Utama
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 d-flex">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('admin.promos.index') }}" class="btn btn-warning ms-2">Reset</a>
                                <a href="{{ route('admin.promos.create') }}" class="btn btn-primary ms-auto">
                                    Promo Baru
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="table-responsive table-nowrap">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Judul Promo</th>
                            <th>Banner Promo</th>
                            <th>Rentang Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($promos as $promo)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>
                                        {{ $promo->name }}
                                    </td>
                                    <td>
                                        <img src="{{ $promo->getFirstMediaUrl('cover', 'thumb') }}" class="img-fluid"
                                            style="max-height: 70px" alt="">

                                    </td>
                                    <td>
                                        {{ $promo->daterange }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $promo->status == 'active' ? 'success' : 'danger' }}">{{ $promo->status }}</span>
                                        @if ($promo->is_main)
                                            <span class="badge bg-primary">PopUp Ad</span>
                                        @else
                                            <span class="badge bg-info">{{ $promo->property->subdomain }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="text-nowrap">
                                            <a href="{{ route('admin.promos.edit', $promo->id) }}"
                                                class="btn btn-sm btn-icon me-2">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <button data-url="{{ route('admin.promos.destroy', $promo->id) }}"
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
                    {{ $promos->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
