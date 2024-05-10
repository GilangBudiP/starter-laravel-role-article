<x-app-layout>
    <x-slot name="title">
        Property
    </x-slot>

    <x-slot name="breadcrumb">
        <div class="d-flex justify-content-between align-content-center">Property Detail
            <a href="{{ route('admin.properties.index') }}" style="font-size: 15px">
                <i class='bx bx-arrow-back'></i> Back
            </a>
        </div>
    </x-slot>

    <form action="{{ route('admin.properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-lg-12 mb-3">
                {{-- {{ $errors }} --}}
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Property Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col">
                                <div class="form-group">
                                    <label for="title" class="form-label">Nama Property<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control  @error('name') is-invalid @enderror"
                                        id="name" name="name" required
                                        value="{{ old('name', $property->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="address" class="form-label">Alamat<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="address" id="address"
                                        class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Alamat Property" required
                                        value="{{ old('address', $property->address) }}" required />
                                    @error('address')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="postcode" class="form-label">Kode Pos<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="postcode" id="postcode"
                                        class="form-control  @error('postcode') is-invalid @enderror"
                                        placeholder="Kode Pos" required
                                        value="{{ old('postcode', $property->postcode) }}" required />
                                    @error('postcode')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="Telephone" class="form-label">Telephone<span
                                            class="text-danger">*</span></label>
                                    <input type="number" name="telephone" id="telephone"
                                        class="form-control @error('telephone') is-invalid @enderror"
                                        placeholder="08XXXXX" value="{{ old('telephone', $property->telephone) }}"
                                        required />
                                    @error('telephone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-label">E-mail<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="email" id="email"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="E-mail"
                                        required value="{{ old('email', $property->email) }}" required />
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="tagline" class="form-label">Tagline</label>
                                <input type="text" class="form-control" name="tagline"
                                    value="{{ old('tagline', $property->tagline) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="tagline_font" class="form-label">Font Tagline</label>
                                <input type="text" class="form-control" name="tagline_font"
                                    value="{{ old('tagline_font', $property->tagline_font) }}">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col">
                                <label for="desc" class="form-label">About Property<span
                                        class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control" cols="30" rows="10">{{ $property->seo->description }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="card-title">
                            <h5>Logo Property</h5>
                            <h6 class="card-subtitle text-muted"> Disarankan Dalam format .png</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row ">
                            <div class="col-md-6 mb-3">
                                <div class="mb-4 form-group">
                                    <label for="logo-white" class="form-label">Logo Putih<span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="filepond" id="logo_white" name="logo_white"
                                        required>
                                    @error('logo-white')
                                        <p>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-4 form-group">
                                    <label for="logo-white" class="form-label">Logo Hitam<span
                                            class="text-danger">*</span></label>
                                    <input type="file" class="filepond" id="logo_black" name="logo_black"
                                        required>
                                    @error('logo-black')
                                        <p>{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="card-title">
                            <h5>Cover Property</h5>
                            <h6 class="card-subtitle text-muted">Cover akan ditampilkan pada Homepage property</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 form-group">
                            <label for="cover" class="form-label">Cover<span class="text-danger">*</span></label>
                            <input type="file" class="filepond" id="cover" name="cover" required>
                            @error('cover')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="card-title">
                            <h5>Discover Property image</h5>
                            <h6 class="card-subtitle text-muted">Cover akan ditampilkan pada Section Discovery di
                                Homepage</h6>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 form-group">
                            <label for="discover" class="form-label">Discover<span
                                    class="text-danger">*</span></label>
                            <input type="file" class="filepond" id="discover" name="discover" required>
                            @error('discover')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0">Social Account</h5>
                    </div>
                    <div class="card-body" id="social-media-accounts">
                        @foreach ($property->socialMedia as $account)
                            <div class="row g-3 form-row mb-4">
                                <input type="hidden" name="social_media_id[]" value="{{ $account->id }}">
                                <div class="col-md-3 form-group">
                                    <label for="platform[]">Platform</label>
                                    <select name="platform[]" id="platform[]" class="form-select" data-icon="">
                                        <option value="facebook" data-icon="bx bxl-facebook"
                                            {{ $account->platform == 'facebook' ? 'selected' : '' }}>Facebook
                                        </option>
                                        <option value="twitter" data-icon="bx bxl-twitter"
                                            {{ $account->platform == 'twitter' ? 'selected' : '' }}>Twitter
                                        </option>
                                        <option value="instagram" data-icon="bx bxl-instagram"
                                            {{ $account->platform == 'instagram' ? 'selected' : '' }}>Instagram
                                        </option>
                                        <option value="tiktok" data-icon="bx bxl-tiktok"
                                            {{ $account->platform == 'tiktok' ? 'selected' : '' }}>
                                            TikTok
                                        </option>
                                        <option value="youtube" data-icon="bx bxl-youtube"
                                            {{ $account->platform == 'youtube' ? 'selected' : '' }}>YouTube
                                        </option>
                                    </select>
                                </div>

                                <div class="col-md-3 form-group">
                                    <label for="username[]">Username</label>
                                    <input type="text" name="username[]" id="username[]" class="form-control"
                                        value="{{ $account->username }}">
                                </div>

                                <div class="col-md-3 form-group">
                                    <label for="url[]">URL</label>
                                    <input type="text" name="url[]" id="url[]" class="form-control"
                                        value="{{ $account->url }}">
                                </div>

                                <div class="col-md-3 form-group">
                                    <div class="form-label .d-none .d-sm-block">&nbsp;</div>
                                    <div>
                                        <button class="btn btn-outline-danger delete-row" type="button">
                                            <i class="bx bx-x me-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        <button type="button" id="add-social-media-account" class="btn btn-primary mb-2">Add Social
                            Media</button>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Other Info</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="checkin" class="form-label">Check In<span
                                            class="text-danger">*</span></label>
                                    <input type="time" name="checkin" id="checkin"
                                        class="form-control  @error('checkin') is-invalid @enderror"
                                        placeholder="Check In Time" required value="{{ $property->checkin }}"
                                        required />
                                    @error('checkin')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="checkout" class="form-label">Check Out<span
                                            class="text-danger">*</span></label>
                                    <input type="time" name="checkout" id="checkout"
                                        class="form-control  @error('checkout') is-invalid @enderror"
                                        placeholder="Check Out" required value="{{ $property->checkout }}"
                                        required />
                                    @error('checkout')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 form-group">
                            <label for="Map" class="form-label">Google Maps</label>
                            <div class="alert alert-info">
                                Upload Url Seperti contoh Ini <br>
                                "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.096318580499!2d110.39039381398752!3d-7.7796114793406845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a59c5a6399089%3A0x1d86293b70e6a8a8!2sLPP%20Convention%20Hotel!5e0!3m2!1sen!2sid!4v1680337017337!5m2!1sen!2sid"
                            </div>
                            <input type="text" class="form-control" id="map" name="map"
                                value="{{ $property->map }}" required>
                            @error('map')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="row mb-4">
                            @if ($property->is_hotel)
                                <div class="col-md-4 form-group">
                                    <label for="bookandlinkid" class="form-label">Bookandlink Property ID</label>
                                    <input type="text" class="form-control" name="bookandlink_id"
                                        value="{{ old('bookandlink_id', $property->bookandlink_id) }}">
                                </div>
                            @endif
                            <div class="col-md-4 form-group">
                                <label for="status" class="form-label">Set Status Of Property</label>
                                <select name="status" id="status" class="form-select" required>
                                    <option value="1"
                                        {{ old('status', $property->status) == 1 ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0"
                                        {{ old('status', $property->status) == 0 ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @push('scripts')
        <script>
            $(document).ready(function() {
                $('.select2').select2({
                    templateResult: function(data, container) {
                        if (!data.id) {
                            return data.text;
                        }
                        var $element = $(data.element);
                        var icon = $element.data('icon');
                        var $result = $('<span><i class="' + icon + '"></i> ' + data.text + '</span>');
                        return $result;
                    },
                    templateSelection: function(data, container) {
                        if (!data.id) {
                            return data.text;
                        }
                        var $element = $(data.element);
                        var icon = $element.data('icon');
                        var $result = $('<span><i class="' + icon + '"></i> ' + data.text + '</span>');
                        return $result;
                    }
                });
            });

            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateSize, FilePondPluginFileValidateType);
            const inputWhiteElement = document.querySelector('input[id="logo_white"]');
            const inputBlackElement = document.querySelector('input[id="logo_black"]');
            const inputElement = document.querySelector('input[id="cover"]');
            const inputDiscoverElement = document.querySelector('input[id="discover"]');

            const pondWhite = FilePond.create(inputWhiteElement, {
                allowImagePreview: true,
                maxFileSize: '1MB',
                labelMaxFileSizeExceeded: 'File is too large. Maximum file size is 1 MB.',
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
                server: {
                    process: {
                        url: '{{ route('admin.upload', 'logo_white') }}',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    revert: {
                        url: '{{ route('admin.upload.destroy', 'logo_white') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            '_method': 'DELETE',
                        },
                    },
                    load: (uniqueFileId, load) => {
                        fetch(uniqueFileId)
                            .then(res => res.blob())
                            .then(load);
                    },
                    remove: (source, load) => {
                        var id = source.split('/').slice(-2)[0];
                        var url =
                            "{{ route('admin.properties.destroy-image', ['property' => $property->id, 'image' => ':id']) }}";
                        url = url.replace(':id', id);

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
                        })
                    }
                },
            });

            const pondBlack = FilePond.create(inputBlackElement, {
                allowImagePreview: true,
                maxFileSize: '1MB',
                labelMaxFileSizeExceeded: 'File is too large. Maximum file size is 1 MB.',
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
                server: {
                    process: {
                        url: '{{ route('admin.upload', 'logo_black') }}',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    revert: {
                        url: '{{ route('admin.upload.destroy', 'logo_black') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            '_method': 'DELETE',
                        },
                    },
                    load: (uniqueFileId, load) => {
                        fetch(uniqueFileId)
                            .then(res => res.blob())
                            .then(load);
                    },
                    remove: (source, load) => {
                        var id = source.split('/').slice(-2)[0];
                        var url =
                            "{{ route('admin.properties.destroy-image', ['property' => $property->id, 'image' => ':id']) }}";
                        url = url.replace(':id', id);

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
                        })
                    }
                },
            });

            // Create a FilePond instance for cover
            const pond = FilePond.create(inputElement, {
                allowImagePreview: true,
                maxFileSize: '2MB',
                labelMaxFileSizeExceeded: 'File is too large. Maximum file size is 2 MB.',
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
                server: {
                    process: {
                        url: '{{ route('admin.upload', 'cover') }}',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    revert: {
                        url: '{{ route('admin.upload.destroy', 'cover') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            '_method': 'DELETE',
                        },
                    },
                    load: (uniqueFileId, load) => {
                        fetch(uniqueFileId)
                            .then(res => res.blob())
                            .then(load);
                    },
                    remove: (source, load) => {
                        var id = source.split('/').slice(-2)[0];
                        var url =
                            "{{ route('admin.properties.destroy-image', ['property' => $property->id, 'image' => ':id']) }}";
                        url = url.replace(':id', id);

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
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                        })
                    }
                },
            });

            const pondDiscover = FilePond.create(inputDiscoverElement, {
                allowImagePreview: true,
                maxFileSize: '2MB',
                labelMaxFileSizeExceeded: 'File is too large. Maximum file size is 2 MB.',
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
                server: {
                    process: {
                        url: '{{ route('admin.upload', 'discover') }}',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    revert: {
                        url: '{{ route('admin.upload.destroy', 'discover') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            '_method': 'DELETE',
                        },
                    },
                    load: (uniqueFileId, load) => {
                        fetch(uniqueFileId)
                            .then(res => res.blob())
                            .then(load);
                    },
                    remove: (source, load) => {
                        var id = source.split('/').slice(-2)[0];
                        var url =
                            "{{ route('admin.properties.destroy-image', ['property' => $property->id, 'image' => ':id']) }}";
                        url = url.replace(':id', id);

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
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                        })
                    }
                },
            });

            @if ($property->hasMedia('cover'))
                // Set initial file if there is a file in the collection
                pond.setOptions({
                    files: [{
                        source: '{{ $property->getFirstMediaUrl('cover') }}',
                        options: {
                            type: 'local',
                        },
                    }, ],
                });
            @endif

            @if ($property->hasMedia('logo_white'))
                // Set initial file if there is a file in the collection
                pondWhite.setOptions({
                    files: [{
                        source: '{{ $property->getFirstMediaUrl('logo_white') }}',
                        options: {
                            type: 'local',
                        },
                    }, ],
                });
            @endif

            @if ($property->hasMedia('logo_black'))
                // Set initial file if there is a file in the collection
                pondBlack.setOptions({
                    files: [{
                        source: '{{ $property->getFirstMediaUrl('logo_black') }}',
                        options: {
                            type: 'local',
                        },
                    }, ],
                });
            @endif

            @if ($property->hasMedia('discover'))
                // Set initial file if there is a file in the collection
                pondDiscover.setOptions({
                    files: [{
                        source: '{{ $property->getFirstMediaUrl('discover') }}',
                        options: {
                            type: 'local',
                        },
                    }, ],
                });
            @endif

            $(document).ready(function() {
                var socialMediaAccounts = $('#social-media-accounts');

                $('#add-social-media-account').click(function() {
                    // Create new row
                    var newRow = '<div class="row g-3 form-row">' +
                        '<input type="hidden" name="social_media_id[]">' +
                        '<div class="col-md-3 form-group">' +
                        '<label for="platform[]">Platform</label>' +
                        '<select name="platform[]" id="platform[]" class="form-select">' +
                        '<option value="facebook" data-icon="bx bxl-facebook">Facebook</option>' +
                        '<option value="twitter" data-icon="bx bxl-twitter">Twitter</option>' +
                        '<option value="instagram" data-icon="bx bxl-instagram"</i>Instagram</option>' +
                        '<option value="tiktok" data-icon="bx bxl-tiktok"></i>TikTok</option>' +
                        '<option value="youtube" data-icon="bx bxl-youtube">YouTube</option>' +
                        '</select>' +
                        '</div>' +
                        '<div class="col-md-3 form-group">' +
                        '<label for="username[]">Username</label>' +
                        '<input type="text" name="username[]" id="username[]" class="form-control">' +
                        '</div>' +
                        '<div class="col-md-3 form-group">' +
                        '<label for="url[]">URL</label>' +
                        '<input type="text" name="url[]" id="url[]" class="form-control">' +
                        '</div>' +
                        '<div class="col-md-2 form-group">' +
                        '<label for="" class="form-label .d-none .d-sm-block">&nbsp;</label>' +
                        '<div>' +
                        '<button class="btn btn-outline-danger delete-row" type="button"><i class="bx bx-x me-1"></i></button>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    // var removeButton = $('<button>').attr('type', 'button').addClass('btn btn-danger').text(
                    //     'Remove Account');
                    // newAccount.append(removeButton);

                    socialMediaAccounts.append(newRow);
                });

                ClassicEditor.create(document.querySelector('#description'), {
                        toolbar: ['heading', 'bold', 'italic', 'link', 'undo', 'redo', 'numberedList',
                            'bulletedList'
                        ]
                    })
                    .catch(error => {
                        console.error(error);
                    });

                $(document).ready(function() {
                    // Listen for click events on delete buttons
                    $(document).on('click', '.delete-row', function() {
                        // Remove the corresponding row from the DOM
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
                });
            });
        </script>
    @endpush

</x-app-layout>
