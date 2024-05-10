<x-app-layout>
    <x-slot name="breadcrumb">
        <div class="d-flex justify-content-between align-content-center">
            <h4>Edit Data Facility</h4>
            <a class="btn btn-primary" href="{{ route('admin.facilities.index') }}" style="font-size: 15px">
                <i class='bx bx-arrow-back'></i> Back
            </a>
        </div>
    </x-slot>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <form action="{{ route('admin.facilities.save-rooms', $facility->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h5 class="card-title m-0">List Room with this Facility</h5>
                    </div>
                    <div class="table-responsive table-nowrap">
                        <table class="table">
                            <tr>
                                <td>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAllEditRole">
                                    </div>
                                    @push('scripts')
                                        <script>
                                            "use strict";
                                            $(function() {
                                                $("#selectAllEditRole").click(function() {
                                                    $("input:checkbox").prop('checked', $(this).prop("checked"));
                                                });
                                            });
                                        </script>
                                    @endpush
                                </td>
                                <td>Nama Kamar</td>
                                <td>Nama Property</td>
                            </tr>
                            @foreach ($rooms as $room)
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" name="room_id[]" value="{{ $room->id }}"
                                                type="checkbox" {{ $facility->hasByRoom($room) ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td>
                                        {{ $room->name }}
                                    </td>
                                    <td>
                                        {{ $room->property->name }}
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">Edit Facility</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.facilities.update', $facility->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Input Facility Name" id="name"
                                        value="{{ old('name', $facility->name) }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="icon" class="form-label">Choose Icon</label>
                                    <select name="icon" id="icon" class="selectpicker show-tick"
                                        data-width="100%" title="Pilih Salah Satu Icon">
                                        {{-- <option value="{{ $facility->icon->class }}" selected data-icon="{{ $facility->icon->class }}">{{ $facility->icon->class }}</option> --}}
                                        <x-facility._icon-list :value="@$facility->icon->class" />
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" data-width="100%"
                                    class="selectpicker @error('status') is-invalid @enderror">
                                    <option value="active"
                                        {{ old('status', $facility->status) == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive"
                                        {{ old('status', $facility->status) == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </form>
                    @push('scripts')
                        <script>
                            "use strict";
                            $(function() {
                                var e = $(".selectpicker"),
                                    t = $(".select2"),
                                    i = $(".select2-icons");

                                function l(e) {
                                    return e.id ? "<i class='customicon-" + $(e.element).data("icon") +
                                        " me-2 custom-icon'></i>" + e
                                        .text : e.text
                                }
                                e.length && e.selectpicker(),
                                    t.length && t.each(function() {
                                        var e = $(this);
                                        e.wrap('<div class="position-relative"></div>').select2({
                                            placeholder: "Select value",
                                            dropdownParent: e.parent()
                                        })
                                    }),
                                    i.length && i.select2({
                                        templateResult: l,
                                        templateSelection: l,
                                        escapeMarkup: function(e) {
                                            return e
                                        }
                                    })
                            });
                        </script>
                    @endpush
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
