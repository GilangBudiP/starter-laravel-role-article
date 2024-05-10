<x-app-layout>
    <x-slot name="breadcrumb">
        Edit Data Promo
    </x-slot>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edit Promo {{ $promo->name }}
                </div>
                <div class="card-body">
                    <form id="formEdit" action="{{ route('admin.promos.update', $promo->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-label">Cover Banner</label>
                                    <input type="file" class="filepond" id="cover" name="cover" required>
                                </div>
                                <div id="floatingInputHelp" class="form-text">Ukuran rekomendasi (1208x302)</div>
                                @error('cover')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Judul Promo</label>
                                    <input type="text" class="form-control  @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name', $promo->name) }}" id="name"
                                        placeholder="Masukkan Nama Promo">
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="property_id" class="form-label">Lokasi Iklan</label>
                                    <select class="form-select @error('property_id') is-invalid @enderror" name="property_id"
                                        value="{{ old('property_id') }}" id="property_id" >
                                        <option value="0" {{ old('property_id', $promo->property_id) == 0 ? 'selected':'' }}>Website Utama</option>
                                        @foreach ($properties as $property)
                                            <option value="{{ $property->id }}" {{ old('property_id', $promo->property_id) == $property->id ? 'selected':'' }}>{{ $property->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('property_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="active" {{ old('status',$promo->status) == 'active'?'selected':'' }}>Aktif</option>
                                        <option value="inactive" {{ old('status',$promo->status) == 'inactive'?'selected':'' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="daterange" class="form-label">Daterange</label>
                                    <input type="text" name="daterange"
                                        value="{{ old('daterange', $promo->daterange) }}"
                                        class="daterange form-control @error('daterange') is-invalid @enderror">
                                </div>
                                @error('daterange')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $promo->description) }}</textarea>
                                </div>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <button type="submit" onclick="$('#formEdit').submit()" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('admin/css/flatpickr-style.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/libs/flatpickr/flatpickr.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('admin/libs/flatpickr/flatpickr.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.daterange').flatpickr({
                    mode: "range",
                    dateFormat: "Y-m-d",
                });
            });
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateSize);
            const inputElement = document.querySelector('input[id="cover"]');
            const pond = FilePond.create(inputElement);
            // FilePond.setOptions({
            //     server: {
            //         url: "{{ route('admin.upload', 'cover') }}",
            //         headers: {
            //             'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //         }
            //     }
            // });
            FilePond.setOptions({
                allowImagePreview: true,
                maxFileSize: '1MB',
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
                        console.log(id);
                        var url =
                            "{{ route('admin.promos.destroy-image', ['promo' => $promo->id, 'image' => ':id']) }}";
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
                @if ($promo->hasMedia('cover'))
                    files: [{
                        source: '{{ $promo->getFirstMediaUrl('cover') }}',
                        options: {
                            type: 'local',
                        },
                    }, ],
                @endif

            });
        </script>
    @endpush
</x-app-layout>
