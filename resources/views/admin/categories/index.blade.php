<x-app-layout>
    <x-slot name="title">
        Kategori
    </x-slot>

    <x-slot name="breadcrumb">
        <span class="text-muted fw-light">Artikel /</span> Kategori
    </x-slot>

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex justify-content-between align-content-center">
                        Kategori
                        <button type="button" data-bs-toggle="modal" data-bs-target="#addKategoriModal"
                            class="btn btn-sm btn-primary"><i class='bx bx-plus'></i>
                            Tambah Kategori
                        </button>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @forelse ($categories as $category)
                                    <tr>
                                        <td><i class="fab fa-angular fa-lg text-danger me-3"></i>
                                            <strong>{{ $category->name }}</strong>
                                        </td>
                                        <td>{{ $category->seo->description }}</td>
                                        <td>
                                            <span class="text-nowrap">
                                                <button class="btn btn-sm btn-icon me-2 text-warning edit-category"
                                                    type="button" data-toggle="tooltip" data-placement="top"
                                                    title="Edit" data-bs-toggle="modal"
                                                    data-bs-target="#editKategoriModal"
                                                    data-category-id="{{ $category->id }}"
                                                    data-action="{{ route('admin.categories.update', $category->id) }}"><i
                                                        class="bx bx-edit"></i>
                                                </button>
                                                <button onclick="deleteCategory(this.dataset.url)"
                                                    data-url="{{ route('admin.categories.destroy', $category->id) }}"
                                                    data-toggle="tooltip" data-placement="top" title="Hapus"
                                                    class="btn btn-sm btn-icon text-danger delete-record">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            Category data not found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <form method="POST" id="deleteForm" action="">
                            @csrf
                            @method('DELETE')

                        </form>
                    </div>
                    <div class="card-footer pb-0">
                        {{ $categories->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal kategori -->
    <div class="modal fade" id="addKategoriModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" action="{{ route('admin.categories.store') }}" method="POST"
                id="addKategoriForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addKategoriModalTitle">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="name" class="form-label">Kategori <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Masukkan Kategori Baru" required />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="desc" class="form-label">Deskripsi <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="description" id="description" class="form-control"
                                placeholder="Tambah Deskripsi" required />
                        </div>
                    </div>
                    <!-- Alert message -->
                    <div id="alert" class="alert alert-danger d-none" role="alert">
                        Kategori sudah ada!
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End add category modal -->

    <!-- Edit Modal kategori -->
    <div class="modal fade" id="editKategoriModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" id="editKategoriForm">
                @method('PUT')
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editKategoriModalTitle">Edit Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="name" class="form-label">Kategori <span
                                    class="text-danger">*</span></label>
                            <input id="edit-category-id" type="hidden" />
                            <input type="text" name="name" id="name" class="form-control"
                                placeholder="Masukkan Kategori Baru" />
                            <div class="invalid-feedback">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="description" class="form-label">Deskripsi<span
                                    class="text-danger">*</span></label>
                            <input type="text" name="description" id="description" class="form-control"
                                placeholder="Tambah Deskripsi" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Edit category modal -->

    @push('scripts')
        <link rel="stylesheet" href="{{ asset('admin/libs/sweetalert/sweetalert2.css') }}">
        </link>
        <script src="{{ asset('admin/libs/sweetalert/sweetalert2.js') }}"></script>
        <script>
            const addKategoriForm = document.getElementById('addKategoriForm');
            const kategoriInput = document.getElementById('name');

            addKategoriForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const kategori = kategoriInput.value;
                const categories = {!! json_encode($categories->pluck('name')) !!};
                if (categories.includes(kategori)) {
                    const alertEl = document.getElementById("alert");
                    alertEl.classList.remove("d-none");
                    setTimeout(() => {
                        alertEl.classList.add("fade");
                        setTimeout(() => {
                            alertEl.classList.add("d-none");
                            alertEl.classList.remove("fade");
                        }, 1000);
                    }, 3000); // alert akan hilang setelah 3 detik (3000 ms
                } else {
                    addKategoriForm.submit();
                }
            });

            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'Ok'
                })
            @endif

            function deleteCategory(url) {
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


            $('.edit-category').on('click', function() {
                var categoryId = $(this).data('category-id');
                console.log(categoryId);
                // $('#edit-record-id').val(categoryId);
                $.ajax({
                    url: '/admin/categories/' + categoryId + '/edit',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        console.log(data);
                        $('#editKategoriModal input[name="name"]').val(data.name);
                        $('#editKategoriModal input[name="description"]').val(data.description);
                        // Isi dengan nama field pada form modal Anda
                    }
                })

            })

            $(document).on('click', '.edit-category', function() {
                var action = $(this).data('action');
                $('#editKategoriForm').attr('action', action);
            });
        </script>
    @endpush

</x-app-layout>
