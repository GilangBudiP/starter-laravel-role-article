<x-app-layout>
    <x-slot name="breadcrumb">
        Tambah Service Baru
    </x-slot>

    <form id="formCreate" action="{{ route('admin.services.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        Buat Service Baru
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">Nama Service</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" id="name" placeholder="Masukkan Nama Service">
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="form-label">Cover</label>
                                    <input type="file" class="filepond @error('cover') is-invalid @enderror" id="cover" name="cover" required>
                                </div>
                                {{-- <div id="floatingInputHelp" class="form-text">Ukuran rekomendasi (1208x302)</div> --}}
                                @error('cover')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                </div>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" id="price"
                                        value="{{ old('price') }}">
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="active">Aktif</option>
                                        <option value="inactive">Tidak Aktif</option>
                                    </select>
                                </div>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" onclick="$('#formCreate').submit()"
                            class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header">
                        Input Gambar
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="file" class="form-control filepound" name="images[]" id="images" multiple
                                data-required>
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
            const imagesElement = document.querySelector('input[id="images"]');
            const images = FilePond.create(imagesElement, {
                acceptedFileTypes: ['image/*'],
                maxFiles: 10,
                maxFileSize: '2MB',
                maxTotalFileSize: '20MB',
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
            const coverElement = document.querySelector('input[id="cover"]');
            const cover = FilePond.create(coverElement, {
                maxFileSize: '2MB',
                server: {
                    url: "{{ route('admin.upload', 'cover') }}",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });
            ClassicEditor.create(document.querySelector('#description'), {
                    toolbar: ['heading', 'bold', 'italic', 'link', 'undo', 'redo', 'numberedList', 'bulletedList']
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush
</x-app-layout>
