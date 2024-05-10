<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-2">
            <h6 class="fw-normal">Total {{ $role->users_count }} users</h6>
            <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                @forelse ($role->users as $user)
                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top"
                        class="avatar avatar-sm pull-up" aria-label="{{ $user->name }}"
                        data-bs-original-title="{{ $user->name }}">
                        <img class="rounded-circle" src="{{ $user->avatar_url }}" alt="Avatar">
                    </li>
                @empty
                    No Users
                @endforelse
            </ul>
        </div>
        <div class="d-flex justify-content-between align-items-end">
            <div class="role-heading">
                <h4 class="mb-1">{{ $role->name }}</h4>
                <a href="javascript:;" onclick="loadEditModal(this.dataset.url)"
                    data-url="{{ route('admin.roles.edit', $role->id) }}" class="role-edit-modal"><small>Edit
                        Role</small></a>
            </div>
            <a href="javascript:void(0);" onclick="deleteRole(this.dataset.url)"
                data-url="{{ route('admin.roles.destroy', $role->id) }}" class="text-danger"><i
                    class="bx bx-trash"></i></a>
        </div>
    </div>
</div>
