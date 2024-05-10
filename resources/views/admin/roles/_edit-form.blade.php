<form id="editRoleForm" class="row g-3" action="{{ route('admin.roles.update', $role->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="col-12 mb-4 fv-plugins-icon-container">
        <label class="form-label" for="addRoleName">Role Name</label>
        <input type="text" id="addRoleName" name="name" class="form-control" value="{{ old('name', $role->name) }}"
            placeholder="Enter a role name" tabindex="-1">
        <div class=""></div>
    </div>
    <div class="col-12">
        <h4>Role Permissions</h4>
        <!-- Permission table -->
        <div class="table-responsive">
            <table class="table table-flush-spacing">
                <tbody>
                    <tr>
                        <td class="text-nowrap fw-semibold">Administrator Access
                        </td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAllEditRole">
                                <label class="form-check-label" for="selectAllEditRole">
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
                                            <input class="form-check-input" type="checkbox" name="permission[]"
                                                id="permission{{ $permission->id }}" value="{{ $permission->id }}"
                                                {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
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
                                    No permission found, please add permission first <a
                                        href="{{ route('admin.permissions.index') }}">here</a>.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Permission table -->
    </div>
    <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
    </div>
    <input type="hidden">
</form>
