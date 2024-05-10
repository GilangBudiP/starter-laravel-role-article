<x-app-layout>
    <x-slot name="breadcrumb">
        New Room
    </x-slot>
    <form action="{{ route('admin.rooms.store') }}" id="createForm" method="POST" enctype="multipart/form-data">
        <div class="row g-4">
            @csrf
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title m-0">Deskripsi Kamar</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="property" class="form-label">Property*</label>
                                    <select name="property_id" id="property"
                                        class="selectpicker @error('property_id') is-invalid @enderror"
                                        data-width="100%" title="Pilih Salah Satu Property" required>
                                        @foreach ($properties as $property)
                                            <option value={{ $property->id }}
                                                {{ old('property_id') == $property->id ? 'selected' : '' }}
                                                class="selectable">{{ $property->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('property_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            @push('scripts')
                                <script>
                                    $(document).ready(function() {
                                        $('#property').on('change', function() {
                                            var property = $(this).find(':selected.selectable').text();
                                            $('.property').text(property);
                                        });
                                    });
                                </script>
                            @endpush
                            <div class="col-md-6 align-self-end">
                                <div class="form-gorup">
                                    <div class="alert alert-warning mb-0">
                                        Anda sedang membuat kamar untuk property <span class="fw-bold property">Pilih
                                            Property</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Name*</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" placeholder="Nama Tipe Kamar" id="name"
                                        value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="slug" class="form-label">Slug<a
                                            class="ms-2 text-warning fw-semibold" href="#!"
                                            onclick="$('#slug').attr('readonly', false)">Edit</a></label>
                                    <input type="text" class="form-control" name="slug" id="slug"
                                        placeholder="Auto generated or choose your own" value="{{ old('slug') }}"
                                        readonly>
                                </div>
                            </div>
                            @push('scripts')
                                <script>
                                    function slugify(text) {
                                        return text.toString().toLowerCase()
                                            .replace(/\s+/g, '-') // Replace spaces with -
                                            .replace(/[^\w\-]+/g, '') // Remove all non-word chars
                                            .replace(/\-\-+/g, '-') // Replace multiple - with single -
                                            .replace(/^-+/, '') // Trim - from start of text
                                            .replace(/-+$/, ''); // Trim - from end of text
                                    }
                                    $('#name').on('keyup', function() {
                                        $('#slug').val(slugify($(this).val()));
                                    });
                                </script>
                            @endpush
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="is-invalid" id="description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Foto Kamar*</h5>
                        <h6 class="card-subtitle text-muted">Max 10 files dengan total ukuran max 15 MB (Dalam format
                            jpg,
                            dan png)</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="file" class="form-control filepound" name="images[]" id="images" multiple
                                data-required>
                        </div>
                    </div>
                </div>
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Price Rate*</h5>
                    </div>
                    <div class="card-body" id="form-price">
                        <div class="alert alert-info">
                            Tambahkan rate harga untuk kamar ini dengan klik tombol tambah dibawah. Anda dapat
                            menambahkan lebih dari satu rate harga.
                        </div>
                        @error('room_prices')
                            <div class="alert alert-danger">
                                Mohon isi rate harga kamar
                            </div>
                        @enderror
                        @error('room_prices.*.price')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        @error('room_prices.*.price_type')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        @error('room_prices.*.daterange')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        <br>
                        @if (
                            $errors->has('room_prices.*.price') ||
                                $errors->has('room_prices.*.price_type') ||
                                $errors->has('room_prices.*.daterange'))
                            @foreach (old('room_prices') as $key => $room_price)
                                <div class="row g-3 form-row mb-4" data-id="{{ $key }}">
                                    <div class="col-md-3 form-group">
                                        <label for="price-type-{{ $key }}" class="form-label">Hari</label>
                                        <select name="room_prices[{{ $key }}][price_type]"
                                            id="price-type-{{ $key }}" class="form-control price-type"
                                            data-width="100%" required aria-required="true">
                                            <option value="1"
                                                {{ $room_price['price_type'] == 1 ? 'selected' : '' }}>
                                                Weekday</option>
                                            <option value="2"
                                                {{ $room_price['price_type'] == 2 ? 'selected' : '' }}>
                                                Weekend</option>
                                            <option value="3"
                                                {{ $room_price['price_type'] == 3 ? 'selected' : '' }}>
                                                Kustom Tanggal</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 form-group">
                                        <label for="price-{{ $key }}" class="form-label">Harga</label>
                                        <input name="room_prices[{{ $key }}][price]" type="text"
                                            id="price-{{ $key }}"
                                            class="form-control @error('prices.' . $key) is-invalid @enderror"
                                            placeholder value="{{ $room_price['price'] }}" required
                                            aria-required="true" />
                                    </div>
                                    <div class="col-md-4 form-group daterange-{{ $key }}">
                                        <label for="daterange-{{ $key }}"
                                            class="form-label {{ $room_price['price_type'] == 3 ? '' : 'd-none' }}">Rentang
                                            Tanggal</label>
                                        <input type="text" name="room_prices[{{ $key }}][daterange]"
                                            id="daterange-{{ $key }}"
                                            class="form-control daterange {{ $room_price['price_type'] == 3 ? '' : 'd-none' }}"
                                            value="{{ $room_price['daterange'] }}" required aria-required="true" />
                                    </div>
                                    <div class="col-md-2 form-group">
                                        <label for="" class="form-label .d-none .d-sm-block">&nbsp;</label>
                                        <div>
                                            <button class="btn btn-outline-danger delete-row" type="button">
                                                <i class="bx bx-x me-1"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary add-row" type="button">
                            <i class="bx bx-plus me-1"></i>
                            <span class="align-middle">Add</span>
                        </button>
                    </div>
                    @push('styles')
                        <link rel="stylesheet" href="{{ asset('admin/libs/flatpickr/flatpickr.css') }}">
                        <link rel="stylesheet" href="{{ asset('admin/css/flatpickr-style.css') }}">
                    @endpush
                    @push('scripts')
                        <script src="{{ asset('admin/libs/flatpickr/flatpickr.js') }}"></script>
                        <script>
                            $('#form-price').on('change', '.price-type', function() {
                                var row = $(this).closest('.form-row');
                                // console.log('test');
                                if ($(this).val() == 3) {
                                    row.find('.daterange').removeClass('d-none');
                                    row.find('label[for="daterange-' + row.data('id') + '"]').removeClass('d-none');
                                } else {
                                    row.find('.daterange').addClass('d-none');
                                    row.find('label[for="daterange-' + row.data('id') + '"]').addClass('d-none');
                                }
                            });
                            var id = 1;
                            var maxInput = 10;
                            $('.add-row').click(function() {
                                id++;
                                var row = '<div class="row g-3 form-row mb-4" data-id="' + id + '">' +
                                    '<div class="col-md-3 form-group">' +
                                    '<label for="price-type-' + id + '" class="form-label">Hari</label>' +
                                    '<select name="room_prices[' + id + '][price_type]" id="price-type-' + id +
                                    '" class="form-control price-type"' +
                                    'data-width="100%" required aria-required="true">' +
                                    '<option value="1">Weekday</option>' +
                                    '<option value="2">Weekend</option>' +
                                    '<option value="3">Kustom Tanggal</option>' +
                                    '</select>' +
                                    '</div>' +
                                    '<div class="col-md-3 form-group">' +
                                    '<label for="price-' + id + '" class="form-label">Harga</label>' +
                                    '<input name="room_prices[' + id + '][price]" type="text" id="price-' + id +
                                    '" class="form-control" placeholder="Inputkan harga" required aria-required="true" />' +
                                    '</div>' +
                                    '<div class="col-md-4 form-group daterange-' + id + '">' +
                                    '<label for="daterange-' + id + '" class="form-label d-none">Rentang Tanggal</label>' +
                                    '<input type="text" name="room_prices[' + id + '][daterange]" id="daterange-' + id +
                                    '" class="form-control daterange d-none" required aria-required="true" />' +
                                    '</div>' +
                                    '<div class="col-md-2 form-group">' +
                                    '<label for="" class="form-label .d-none .d-sm-block">&nbsp;</label>' +
                                    '<div>' +
                                    '<button class="btn btn-outline-danger delete-row" type="button">' +
                                    '<i class="bx bx-x me-1"></i>' +
                                    '</button>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>';
                                var count = $('.form-row').length;
                                if (count > (maxInput - 1)) {
                                    alert('You have reached the limit of adding ' + count + ' inputs');
                                } else {
                                    $('#form-price').append(row);
                                }
                                $('#daterange-' + id).flatpickr({
                                    mode: "range",
                                    dateFormat: "Y-m-d",
                                    minDate: "today",
                                });
                            });
                            $('#form-price').on('click', '.delete-row', function() {
                                Swal.fire({
                                    title: 'Are you sure?',
                                    text: "You won't be able to revert this!",
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonText: 'Yes, delete it!'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        $(this).closest('.form-row').remove();
                                        Swal.fire(
                                            'Deleted!',
                                            'Row successfully deleted!.',
                                            'success'
                                        )
                                    }
                                });
                            });
                            $('.daterange').flatpickr({
                                mode: "range",
                                dateFormat: "Y-m-d",
                                minDate: "today",
                                disableMobile: true,
                            });
                        </script>
                    @endpush
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title m-0">Facilities</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="facilities" class="form-label">Facility</label>
                            <select name="facilities[]" id="facilities" class="select2-icons" multiple="multiple"
                                required>
                                @foreach ($facilities as $facility)
                                    <option value="{{ $facility->id }}" id="facility-{{ $facility->id }}"
                                        data-icon="{{ $facility->icon->class ?? '' }}"
                                        {{ in_array($facility->id, old('facilities', [])) ? 'selected' : '' }}>
                                        {{ $facility->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">
                                Buat fasilitas kamar baru <a href="{{ route('admin.facilities.index') }}"
                                    class="fw-semibold">disini</a>
                            </div>
                        </div>
                    </div>
                    @push('styles')
                        <style>
                            .custom-icon {
                                font-size: 1rem;
                                text-align: center;
                            }
                        </style>
                    @endpush
                    @push('scripts')
                        <script>
                            "use strict";
                            $(function() {
                                var e = $(".selectpicker"),
                                    t = $(".select2"),
                                    i = $(".select2-icons");

                                function l(e) {
                                    return e.id ? "<i class='" + $(e.element).data("icon") +
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
                                    i.length && i.wrap('<div class="position-relative"></div>').select2({
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
                <div class="card sticky-top">
                    <div class="card-header">
                        <h5 class="card-title m-0">Detail Lain</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 form-group">
                                <label for="bed_type" class="form-label">Bed Type</label>
                                <select name="bed_type" id="bed_type"
                                    class="selectpicker @error('bed_type') is-invalid @enderror" data-width="100%"
                                    title="Choose One">
                                    <option value="twin" {{ old('bed_type') == 'twin' ? 'selected' : '' }}>
                                        Twin Bed
                                    </option>
                                    <option value="king" {{ old('bed_type') == 'king' ? 'selected' : '' }}>
                                        King Bed
                                    </option>
                                    <option value="queen" {{ old('bed_type') == 'queen' ? 'selected' : '' }}>
                                        Queen Bed
                                    </option>
                                    <option value="double" {{ old('bed_type') == 'double' ? 'selected' : '' }}>
                                        Standard Double
                                    </option>
                                </select>
                                @error('bed_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="capacity" class="form-label">Capacity</label>
                                <input type="number" min="0" max="10"
                                    class="form-control @error('capacity') is-invalid @enderror" name="capacity"
                                    id="capacity" value="{{ old('capacity') }}">
                                @error('capacity')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="size" class="form-label">Room Size <span
                                        class="text-lowercase">(m<sup>2</sup>)</span></label>
                                <input type="number" min="0"
                                    class="form-control @error('size') is-invalid @enderror"
                                    value="{{ old('size') }}" name="size" id="size">
                                @error('size')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="qty" class="form-label">Jumlah Unit</label>
                                <input type="number" min="0"
                                    class="form-control @error('qty') is-invalid @enderror"
                                    value="{{ old('qty') }}" name="qty">
                                @error('qty')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="bookandlink_roomid" class="form-label">Bookandlink Room ID</label>
                                <input type="number" min="0" name="bookandlink_roomid"
                                    id="bookandlink_roomid" class="form-control"
                                    value="{{ old('bookandlink_roomid') }}">
                                @error('bookandlink_roomid')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" data-width="100%"
                                    class="selectpicker @error('status') is-invalid @enderror">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12">
                                <div class="form-label">Setel sebagai rekomendasi</div>
                                <input type="checkbox" class="form-check-input" name="is_recommended" value="1"
                                    checked="" id="is_recommended">
                                <label class="form-label" for="is_recommended">Recommended</label>
                                <div class="form-text">Rekomendasi akan dimunculkan di halaman homepage utama.</div>
                                @error('is_recommended')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-12 mt-4">
                                <button class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('scripts')
        <script>
            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginImageExifOrientation,
                FilePondPluginFileValidateSize,
                FilePondPluginFileValidateType
            );
            const inputElement = document.querySelector('input[id="images"]');

            // Create a FilePond instance
            const pond = FilePond.create(inputElement);
            FilePond.setOptions({
                acceptedFileTypes: ['image/*'],
                maxFiles: 10, // set maximum number of files to 3
                maxFileSize: '2MB',
                maxTotalFileSize: '15MB', // set total file size limit to 9MB
                server: {
                    process: {
                        url: "{{ route('admin.upload', 'images') }}?multiple=true",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    revert: {
                        url: "{{ route('admin.upload', 'images') }}?multiple=true",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    restore: (uniqueFileId, load, error) => {
                        var url =
                            "{{ route('admin.upload.restore', ['model' => 'images', 'folder' => ':source']) }}";
                        url = url.replace(':source', uniqueFileId);
                        fetch(url)
                            .then(res => res.json())
                            .then(load)
                            .catch(error);
                    },
                    remove: (source, load) => {
                        var url =
                            "{{ route('admin.upload.tmp.destroy', ['model' => 'images', 'folder' => ':source']) }}";
                        url = url.replace(':source', source);
                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: url,
                                    type: 'DELETE',
                                    data: {
                                        _token: '{{ csrf_token() }}',
                                        _method: 'DELETE',
                                    },
                                    success: res => {
                                        console.log(res);
                                        Swal.fire(
                                            'Deleted!',
                                            'Your file has been deleted.',
                                            'success'
                                        )
                                        load();
                                    }
                                })
                            }
                        });
                    }
                    // load: (source, load) => {
                    //     console.log(source);
                    //     var url =
                    //         "{{ route('admin.upload.restore', ['model' => 'images', 'folder' => ':source']) }}";
                    //     url = url.replace(':source', source);
                    //     fetch(url)
                    //         .then(res => res.blob())
                    //         .then(load);
                    // },
                },
                files: [
                    @foreach (old('images', []) as $image)
                        {
                            source: '{{ $image }}',
                            options: {
                                type: 'local'
                            }
                        },
                    @endforeach
                ],
            });
            ClassicEditor.create(document.querySelector('#description'), {
                    toolbar: ['heading', 'bold', 'italic', 'link', 'undo', 'redo', 'numberedList', 'bulletedList']
                })
                .catch(error => {
                    console.error(error);
                });
            // @error('slug')
            //     $('#slug').attr('readonly', false);
            // @enderror
        </script>
    @endpush
</x-app-layout>
