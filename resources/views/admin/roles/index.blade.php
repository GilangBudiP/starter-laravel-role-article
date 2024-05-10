<x-app-layout>
    <x-slot name="title">
        User Role & Permission Management
    </x-slot>

    <x-slot name="breadcrumb">
        <span class="text-muted fw-light">User Management /</span> Roles
    </x-slot>

    <div class="row justify-content-between g-4">
        <!-- Top stats -->
        @foreach ($roles as $role)
            <div class="col-xl-4 col-lg-6 col-md-6">
                <x-card.role-card :role=$role />
            </div>
        @endforeach
        @can('roles.create')
        <!-- Card to add new role -->
        <div class="col-xl-4 col-lg-6 col-md-6 ms-auto">
            <div class="card h-100">
                <div class="row h-100">
                    <div class="col-sm-5">
                        <div class="d-flex align-items-end h-100 justify-content-center mt-sm-0 mt-3">
                            <img src="{{ asset('admin/img/illustrations/roles-illustration.png') }}" class="img-fluid"
                                alt="Image" width="120"
                                data-app-light-img="illustrations/sitting-girl-with-laptop-light.png"
                                data-app-dark-img="illustrations/sitting-girl-with-laptop-dark.png">
                        </div>
                    </div>
                    <div class="col-sm-7">
                        <div class="card-body text-sm-end text-center ps-sm-0">
                            <button data-bs-target="#addRoleModal" data-bs-toggle="modal"
                                class="btn btn-primary mb-3 text-nowrap add-new-role">Add New Role</button>
                            <p class="mb-0">Add role, if it does not exist</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        @can('roles.delete')
        <!-- Form delete role -->
        <form id="formDelete" action="" method="POST">
            @csrf
            @method('DELETE')
        </form>
        <!-- End form delete role -->
        @endcan
        <!-- End Top stats -->
        @can('users.read')
        <!-- User Table List -->
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">
                        User Management
                    </h5>
                    @can('users.create')
                    <button data-bs-target="#addUserOffcanvas" data-bs-toggle="offcanvas"
                        class="btn btn-primary text-nowrap">
                        Create New User
                    </button>
                    @endcan
                </div>
                {{-- <h5 class="card-header">Hoverable rows</h5> --}}
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-left align-items-center">
                                            <div class="avatar-wrapper">
                                                <div class="avatar avatar-sm me-3">
                                                    <img src="{{ $user->avatar_url }}" alt="Avatar"
                                                        class="rounded-circle">
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <a href="app-user-view-account.html" class="text-body text-truncate">
                                                    <span class="fw-semibold">
                                                        {{ $user->name }}
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $user->email }}
                                    </td>
                                    <td>
                                        <span class="text-truncate d-flex align-items-center"><span
                                                class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2"><i
                                                    class="bx bx-pie-chart-alt bx-xs"></i></span>{{ $user->getRoleNames()->first() }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-label-{{ $user->is_active ? 'primary':'secondary' }} me-1">{{ $user->is_active ? 'Active' : 'Non Active' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-nowrap">
                                            @can('users.update')
                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                class="btn btn-sm btn-icon me-2">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            @endcan
                                            @can('users.delete')
                                            <button onclick="deleteUser(this.dataset.url)" data-url="{{ route('admin.users.destroy', $user->id) }}" class="btn btn-sm btn-icon delete-record">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                            @endcan
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">
                                        No data available
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                {{ $users->links() }}
            </div>
        </div>
        <!-- End User table List -->
        @endcan
    </div>

    @push('modal')
        @can('roles.create')
        <!-- Add Role Modal -->
        <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="form">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addRoleModalLabel">Add New Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="addRoleForm" action="{{ route('admin.roles.store') }}"
                            class="row g-3 fv-plugins-bootstrap5 fv-plugins-framework" method="POST">
                            @csrf
                            <div class="col-12 mb-4">
                                <label class="form-label" for="modalRoleName">Role Name</label>
                                <input type="text" id="modalRoleName" name="name" class="form-control"
                                    placeholder="Enter a role name" tabindex="-1" required>
                                <div class="invalid-feedback">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <h4>Role Permissions</h4>
                                <!-- Role table -->
                                <div class="table-responsive">
                                    <table class="table table-flush-spacing">
                                        <tbody>
                                            <tr>
                                                <td class="text-nowrap fw-semibold">Administrator Access <i
                                                        class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        aria-label="Allows a full access to the system"
                                                        data-bs-original-title="Allows a full access to the system"></i>
                                                </td>
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="selectAllAddRole">
                                                        <label class="form-check-label" for="selectAllAddRole">
                                                            Select All
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @forelse($groupPermissions as $key => $permissions)
                                                <tr>
                                                    <td class="text-nowrap fw-semibold text-capitalize">{{ $key }}
                                                        Management</td>
                                                    <td>
                                                        {{-- {{ $permission }} --}}
                                                        <div class="d-flex">
                                                            @foreach ($permissions as $permission)
                                                                <div class="form-check me-3 me-lg-5">
                                                                    <input class="form-check-input" type="checkbox"
                                                                        id="permission{{ $permission->id }}"
                                                                        name="permission[]"
                                                                        value="{{ $permission->id }}">
                                                                    <label class="form-check-label text-capitalize"
                                                                        for="permission{{ $permission->id }}">
                                                                        {{ $permission->action }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="2">
                                                        <div class="alert alert-warning text-center">
                                                            No permission found, please add permission first.
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Role table -->
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
                                <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
                                    aria-label="Close">Cancel</button>
                            </div>
                            <input type="hidden">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Add Role Modal -->
        @endcan

        @can('roles.update')
        <!-- Edit Role Modal -->
        <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRoleModalLabel">Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="content-dynamic">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Edit Role Modal -->
        @endcan

        @can('users.create')
        <!-- Add User Modal -->
        <!-- End Offcanvas -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="addUserOffcanvas"
            aria-labelledby="addUserOffcanvasLabel">
            <div class="offcanvas-header">
                <h5 id="addUserOffcanvasLabel" class="offcanvas-title">Offcanvas End</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body my-auto mx-0 flex-grow-0">
                <form class="add-new-user pt-0" action="{{ route('admin.users.store') }}" id="addNewUserForm"
                    autocomplete="off" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label" for="add-user-name">Full Name</label>
                        <input type="text" class="form-control" id="add-user-name" placeholder="John Doe"
                            name="name" aria-label="John Doe">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="add-user-email">Email</label>
                        <input type="text" id="add-user-email" class="form-control"
                            placeholder="john.doe@example.com" aria-label="john.doe@example.com" name="email">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3 form-password-toggle">
                        <label class="form-label" for="add-user-password">Password</label>
                        <div class="input-group input-group-merge">
                            <input type="password" id="password" class="form-control" name="password"
                                placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                aria-describedby="password" autocomplete="new-password" />
                            <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="user-role">User Role</label>
                        <select id="user-role" class="form-select" name="role">
                            @forelse($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @empty
                                <option value="#" disabled>No role found, please add role first.</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="form-label">Set User Active Status</div>
                        <input type="checkbox" class="form-check-input" name="status" value="1" checked
                            id="user-status">
                        <label class="form-label" for="user-status">Active</label>
                        <div class="invalid-feedback"></div>
                    </div>
                    <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Submit</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                    <input type="hidden">
                </form>
            </div>
        </div>
        <!-- End Add User Modal -->
        @endcan
    @endpush
    @push('scripts')
        <script>
            @can('roles.create')
            $('#selectAllAddRole').change(function() {
                if (this.checked) {
                    $('input:checkbox').not(this).prop('checked', this.checked);
                } else {
                    $('input:checkbox').not(this).prop('checked', this.checked);
                }
            });
            @endcan

            @can('roles.update')
            $('body').on('change', '#selectAllEditRole', function() {
                if (this.checked) {
                    $('input:checkbox').not(this).prop('checked', this.checked);
                } else {
                    $('input:checkbox').not(this).prop('checked', this.checked);
                }
            });
            var editModal = new bootstrap.Modal('#editRoleModal');

            function loadEditModal(url) {
                editModal.show();
                $('#editRoleModal').find(".content-dynamic").load(url);
            }

            $('#editRoleModal').on('hidden.bs.modal', function() {
                $(this).find(".content-dynamic").html('');
            });
            @endcan

            @can('roles.delete')
            function deleteRole(url) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formDelete').attr('action', url);
                        $('#formDelete').submit();
                    }
                })
            }
            @endcan

            @can('users.delete')
            function deleteUser(url) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#formDelete').attr('action', url);
                        $('#formDelete').submit();
                    }
                })
            }
            @endcan
        </script>
    @endpush
</x-app-layout>
