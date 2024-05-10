<x-app-layout>
    <div class="row g-4">
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
                                                    <img src="{{ asset('admin/img/avatars/2.png') }}" alt="Avatar"
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
                                            class="badge bg-label-primary me-1">{{ $user->is_active ? 'Active' : 'Non Active' }}</span>
                                    </td>
                                    <td>
                                        <span class="text-nowrap">
                                            <a href="{{ route('admin.users.show', $user->id) }}"
                                                class="btn btn-sm btn-icon me-2">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <button class="btn btn-sm btn-icon delete-record">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                            @empty
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
    </div>
</x-app-layout>
