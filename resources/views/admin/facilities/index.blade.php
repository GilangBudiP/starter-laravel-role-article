<x-app-layout>
    <x-slot name="breadcrumb">
        Data Facility
    </x-slot>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">Data Facility</h5>
                </div>
                <div class="table-responsive table-nowrap">
                    <table class="table">
                        <thead>
                            <th>Nama Fasilitas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($facilities as $facility)
                                <tr>
                                    <td>
                                        <i class="{{ $facility->icon->class ?? '' }} me-2"></i>
                                        {{ $facility->name }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge bg-{{ $facility->status == 'active' ? 'success' : 'secondary' }}">{{ $facility->status }}</span>
                                    </td>
                                    <td>
                                        <span class="text-norap">
                                            <a href="{{ route('admin.facilities.edit', $facility->id) }}"
                                                class="btn btn-sm btn-icon me-2">
                                                <i class="bx bx-edit"></i>
                                            </a>
                                            <button data-url="{{ route('admin.facilities.destroy', $facility->id) }}"
                                                onclick="deleteFacility(this.dataset.url)" class="btn btn-sm btn-icon">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" align="center">
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
                </div>
                <div class="card-footer">
                    {{ $facilities->links() }}
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title m-0">Input New Room Facility</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.facilities.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="Input Facility Name" id="name" value="{{ old('name') }}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="icon" class="form-label">Choose Icon</label>
                                    <select name="icon" id="icon" class="selectpicker show-tick"
                                        data-width="100%" title="Pilih Salah Satu Icon">
                                        {{-- @include('admin.facilities._icon-list') --}}
                                        <x-facility._icon-list />
                                    </select>
                                </div>
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
    @push('scripts')
        <script>
            function deleteFacility(url) {
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
</x-app-layout>
