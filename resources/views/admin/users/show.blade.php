<x-app-layout>
    <div class="row">
        <!-- User Sidebar -->
        <div class="order-1 col-xl-4 col-lg-5 col-md-5 order-md-0">
            <!-- User Card -->
            <div class="mb-4 card">
                <div class="card-body">
                    <div class="user-avatar-section">
                        <div class=" d-flex align-items-center flex-column">
                            <img class="my-4 rounded img-fluid" src="{{ $user->avatar_url }}" height="110"
                                width="110" alt="User avatar">
                            <div class="text-center user-info">
                                <h4 class="mb-2">{{ $user->name }}</h4>
                                <span class="badge bg-label-secondary">{{ $user->getRoleNames()[0] }}</span>
                            </div>
                        </div>
                    </div>
                    <h5 class="pb-2 mb-4 border-bottom">Details</h5>
                    <div class="info-container">
                        <ul class="list-unstyled">
                            <li class="mb-3">
                                <span class="fw-bold me-2">Username:</span>
                                <span>{{ '@' . $user->username }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Email:</span>
                                <span>{{ $user->email }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Status:</span>
                                @if ($user->is_active == 1)
                                    <span class="badge bg-label-success">Active</span>
                                @else
                                    <span class="badge bg-label-danger">Inactive</span>
                                @endif
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Role:</span>
                                <span>{{ $user->getRoleNames()[0] }}</span>
                            </li>
                            <li class="mb-3">
                                <span class="fw-bold me-2">Contact:</span>
                                <span>{{ $user->contact ?? '-' }}</span>
                            </li>
                        </ul>
                        <div class="pt-3 d-flex justify-content-center">
                            <a href="javascript:;" class="btn btn-primary me-3" data-bs-target="#editUser"
                                data-bs-toggle="modal">Edit</a>
                            @if($user->is_active == 1)
                                <a href="javascript:;" onclick="suspendUser(this.dataset.url)" data-url="{{ route('admin.users.suspend', $user->id) }}" class="btn btn-danger suspend-user">Suspend User</a>
                            @else
                            <a href="javascript:;" onclick="unsuspendUser(this.dataset.url)" data-url="{{ route('admin.users.unsuspend', $user->id) }}" class="btn btn-success suspend-user">Unsuspend User</a>
                            @endif
                            <form action="" id="suspend" method="POST">
                                @csrf
                            </form>
                            <form action="" id="unsuspend" method="POST">
                                @csrf
                            </form>
                        </div>
                        @push('scripts')
                            @can('users.update')
                            <script>
                                function suspendUser(url) {
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: "You will suspend this User!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, suspend user!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $('#suspend').attr('action', url);
                                            $('#suspend').submit();
                                        }
                                    })
                                }
                                function unsuspendUser(url) {
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: "You will unsuspend this User!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, unsuspend user!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $('#suspend').attr('action', url);
                                            $('#suspend').submit();
                                        }
                                    })
                                }
                            </script>
                            @endcan
                        @endpush
                    </div>
                </div>
            </div>
            <!-- /User Card -->
        </div>
        <!--/ User Sidebar -->


        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- User Pills -->
            <ul class="mb-3 nav nav-pills flex-column flex-md-row">
                <li class="nav-item"><a class="nav-link active" href="app-user-view-security.html"><i
                            class="bx bx-lock-alt me-1"></i>Security</a></li>
            </ul>
            <!--/ User Pills -->

            <!-- Change Password -->
            <div class="mb-4 card">
                <h5 class="card-header">Change Password</h5>
                <div class="card-body">
                    <form id="formChangePassword" action="{{ route('admin.users.change-password', $user->id) }}"
                        method="POST" novalidate="novalidate">
                        @csrf
                        @method('PUT')
                        <div class="alert alert-warning" role="alert">
                            <h6 class="mb-1 alert-heading fw-bold">Ensure that these requirements are met</h6>
                            <span>Minimum 8 characters long, uppercase &amp; symbol</span>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-12 col-sm-6 form-password-toggle fv-plugins-icon-container">
                                <label class="form-label" for="newPassword">New Password</label>
                                <div class="input-group input-group-merge has-validation">
                                    <input class="form-control" type="password" id="newPassword" name="password"
                                        placeholder="············">
                                    <span class="cursor-pointer input-group-text"><i class="bx bx-hide"></i></span>
                                </div>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>

                            <div class="mb-3 col-12 col-sm-6 form-password-toggle fv-plugins-icon-container">
                                <label class="form-label" for="confirmPassword">Confirm New Password</label>
                                <div class="input-group input-group-merge has-validation">
                                    <input class="form-control" type="password" name="password_confirmation"
                                        id="confirmPassword" placeholder="············">
                                    <span class="cursor-pointer input-group-text"><i class="bx bx-hide"></i></span>
                                </div>
                                <div class="fv-plugins-message-container invalid-feedback"></div>
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary me-2">Change Password</button>
                            </div>
                        </div>
                        <input type="hidden">
                    </form>
                </div>
            </div>
            <!--/ Change Password -->
            <!-- User's Permissions -->
            <div class="mb-4 card">
                <h5 class="card-header">
                    Permissions
                </h5>
                <div class="table-responsive text-nowrap">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Permission</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        {{-- {{ $userPermissions }} --}}
                        {{-- @foreach ($user->roles as $userRole) --}}
                        @foreach ($userPermissions as $category => $permissions)
                            <tr>
                                <td class="text-capitalize">{{ $category }} Management</td>
                                @foreach ($permissions as $permission)
                                    <td class="text-capitalize">{{ $permission->action }}</td>
                                @endforeach
                                {{-- <td>{{ $permission->category }}</td> --}}
                                {{-- <td>{{ $permission->action }}</td> --}}
                            </tr>
                        @endforeach
                        {{-- @endforeach --}}
                    </table>
                </div>
            </div>
            <!--/ User's Permissions -->
        </div>
        <!--/ User Content -->
        @push('modal')
            <div class="modal {{ $errors->has('updateUser') ? 'show':'' }} fade" id="editUser" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="{{ $errors->has('updateUser') ? 'false':'true' }}">
                <div class="modal-dialog modal-md" role="form">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="editUserForm" action="{{ route('admin.users.update', $user->id) }}" class="row g-3"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="col-md-12">
                                    <label for="avatar" class="form-label">Foto Avatar</label>
                                    <input type='file' class="form-control" id="avatar" name="avatar" />
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="userName">Full Name</label>
                                    <input type="text" id="userName" name="name" class="form-control"
                                        placeholder="Enter user fullname" tabindex="-1"
                                        value="{{ old('name', $user->name) }}" required>
                                    <div class="invalid-feedback">
                                        @error('name')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control"
                                        placeholder="Choose a username">
                                </div>
                                <div class="col-6">
                                    <label for="userEmail" class="form-label">Email</label>
                                    <input type="email" name="email" id="userEmail" class="form-control"
                                        placeholder="Enter valid email" tabindex="-1"
                                        value="{{ old('email', $user->email) }}" required>
                                    <div class="invalid-feedback">
                                        @error('email')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label for="userContact" class="form-label">Contact</label>
                                    <input type="text" name="contact" id="userContact" class="form-control"
                                        placeholder="Enter user contact" tabindex="-1"
                                        value="{{ old('contact', $user->contact) }}">
                                </div>
                                <div class="col-6">
                                    <label for="userRole" class="form-label">User Role</label>
                                    <select name="role_id" id="userRole" class="form-control">
                                        @forelse ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                {{ old('role_id', $role->id) == $role->id ? 'selected' : '' }}>
                                                {{ $role->name }}</option>
                                        @empty
                                            <option>Tambahkan role terlebih dahulu</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="userStatus" class="form-label">Status</label>
                                    <select name="is_active" class="form-control" id="userStatus">
                                        <option value="1"
                                            {{ old('is_active', $user->is_active) === 1 ? 'checked' : '' }}>
                                            Active
                                        </option>
                                        <option value="0"
                                            {{ old('is_active', $user->is_active) === 0 ? 'checked' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="text-center col-12">
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
        @endpush
    </div>
</x-app-layout>
