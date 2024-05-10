<form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST" id="addPermissionForm"
    class="row g-3" novalidate="novalidate">
    @csrf
    @method('PUT')
    <div class="col-12 mb-4 fv-plugins-icon-container">
        <label class="form-label" for="addPermissionName">Permission Name</label>
        <input type="text" id="addPermissionName" name="name" value="{{ old('name', $permission->name) }}"
            class="form-control @error('name') is-invalid @enderror"
            placeholder="Enter a permission name (category.action)" tabindex="-1" required pattern="(/w+)/.(/w+)">
        <div class="invalid-feedback">
            @error('name')
                {{ $message }}
            @enderror
        </div>
    </div>
    <div class="col-12 text-center">
        <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
        <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="modal"
            aria-label="Close">Cancel</button>
    </div>
    {{-- <input type="hidden"> --}}
</form>
