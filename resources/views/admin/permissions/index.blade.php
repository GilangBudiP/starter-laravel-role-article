<x-app-layout>
    <x-slot name="title">
        Permission Management
    </x-slot>

    <div class="row-g-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Data Permission</h5>
                    @can('permissions.create')
                    <button class="btn btn-primary" type="button" data-bs-target="#addPermissionModal"
                        data-bs-toggle="modal" data-bs-dismiss="modal">
                        New Permission
                    </button>
                    @endcan
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Assigned To</th>
                                <th>Created Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($permissions as $permission)
                                <tr>
                                    <td>
                                        <span class="text-nowrap">{{ $permission->name }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success">Role Name</span>
                                    </td>
                                    <td>
                                        <span class="text-nowrap">{{ $permission->created_at }}</span>
                                    </td>
                                    <td>
                                        <span class="text-nowrap">
                                            @can('permissions.update')
                                            <button class="btn btn-sm btn-icon me-2"
                                                onclick="loadEditModal(this.dataset.url)"
                                                data-url="{{ route('admin.permissions.edit', $permission->id) }}">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                            @endcan
                                            @can('permissions.delete')
                                            <button onclick="deletePermission(this.dataset.url)"
                                                data-url="{{ route('admin.permissions.destroy', $permission->id) }}"
                                                class="btn btn-sm btn-icon delete-record">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                            @endcan
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">
                                        Permission data not found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    @can('permissions.delete')
                    <form method="POST" id="deleteForm" action="">
                        @csrf
                        @method('DELETE')

                    </form>
                    @endcan
                </div>
                <div class="card-footer">
                    {{ $permissions->links() }}
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <link rel="stylesheet" href="{{ asset('admin/libs/sweetalert/sweetalert2.css') }}">
        </link>
        <script src="{{ asset('admin/libs/sweetalert/sweetalert2.js') }}"></script>
        <script>
            const addModal = new bootstrap.Modal('#addPermissionModal');
            const editModal = new bootstrap.Modal('#editPermissionModal');

            function loadEditModal(url) {
                editModal.show();
                $('#editPermissionModal').find(".content-dynamic").load(url);
            }

            function deletePermission(url) {
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
    {{-- @can('permission.create') --}}
    @push('modal')
        <!-- Add Permission Modal -->
        <div class="modal fade" id="addPermissionModal" tabindex="-1" aria-labelledby="addPermissionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addPermissionModalLabel">Add Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.permissions.store') }}" method="POST" id="addPermissionForm"
                            class="row g-3">
                            @csrf
                            <div class="alert alert-info text-center my-0" role="alert">
                                Format penulisan permission harus seperti ini : <br>
                                categories.action <br>
                                contoh : posts.read, posts.create, posts.update, categories.read
                            </div>
                            <div class="col-12 mb-4 fv-plugins-icon-container">
                                <label class="form-label" for="addPermissionName">Permission Name</label>
                                <input type="text" id="addPermissionName" name="name" class="form-control"
                                    placeholder="Enter a permission name (category.action)" tabindex="-1" required
                                    pattern="(\w+)\.(\w+)">
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">Cancel</button>
                            </div>
                            {{-- <input type="hidden"> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Edit Role Modal -->
        <!-- Edit Permission Modal -->
        <div class="modal fade" id="editPermissionModal" tabindex="-1" aria-labelledby="editPermissionModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editPermissionModalLabel">Edit Permission</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info text-center" role="alert">
                            Format penulisan permission harus seperti ini : <br>
                            categories.action <br>
                            contoh : posts.read, posts.create, posts.update, categories.read
                        </div>
                        <div class="content-dynamic">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Edit Permission Modal -->
    @endpush
    {{-- @endcan --}}
</x-app-layout>
