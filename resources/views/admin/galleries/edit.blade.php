<x-app-layout>
    <x-slot name="title">
        Gallery
    </x-slot>

    <x-slot name="breadcrumb">
        <div class="d-flex justify-content-between align-content-center">Edit Image
            <a href="{{ route('admin.galleries.index') }}" style="font-size: 15px">
                <i class='bx bx-arrow-back'></i> Back to Gallery
            </a>
        </div>
    </x-slot>

    <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            @method('PUT')
            @csrf
            <div class="col">
                <div class="mb-4 card">
                    <div class="card-header">
                        <h5 class="m-0 card-title">Edit</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Title</label>
                                    <input type="hidden" name="gallery_id" value="{{ $gallery->id }}">
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Image Title" value="{{ $gallery->name }}" />
                                    @error('name')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Slug<a
                                            class="ms-2 text-warning fw-semibold" href="#!"
                                            onclick="$('#slug').attr('readonly', false)">Edit</a></label>
                                    <input type="text" class="form-control" name="slug" id="slug"
                                        placeholder="Auto generated or choose your own" readonly
                                        value="{{ $gallery->slug }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="desc" class="form-label">Status</label>
                                    <select name="status" class="form-control form-select" id="status" required>
                                        <option value="1" {{ $gallery->status === 1 ? 'selected' : '' }}>
                                            Published</option>
                                        <option value="0" {{ $gallery->status === 0 ? 'selected' : '' }}>Draft
                                        </option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-4 col">
                                <label for="image" class="form-label">Image</label>
                                <div class="alert alert-info">
                                    Bisa upload file hingga 3 files dengan total ukuran 9 MB
                                </div>
                                <input type="file" multiple name="gallery[]" id="gallery" data-max-file-size="3MB"
                                    placeholder="Tambah Deskripsi" />
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </form>

    @push('scripts')
        <script>
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateSize, FilePondPluginFileValidateType);
            const inputElement = document.querySelector('input[id="gallery"]');
            const pond = FilePond.create(inputElement);
            pond.setOptions({
                allowImagePreview: true,
                maxFiles: 3, // set maximum number of files to 3
                maxTotalFileSize: '9MB', // set total file size limit to 9MB
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],

                server: {

                    process: {
                        url: '{{ route('admin.upload', 'gallery') }}?multiple=true',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    revert: {
                        url: '{{ route('admin.upload.destroy', 'gallery') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            '_method': 'DELETE',
                        },
                    },
                    load: (source, load) => {
                        fetch(source)
                            .then(res => res.blob())
                            .then(load);
                    },

                    remove: (source, load) => {
                        var id = source.split('/').slice(-2)[0];
                        var url =
                            "{{ route('admin.galleries.destroy-image', ['gallery' => $gallery->id, 'image' => ':id']) }}";
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
                files: [
                    @foreach ($gallery->getMedia('gallery') as $image)
                        {
                            source: '{{ $image->getUrl() }}',
                            options: {
                                type: 'local',
                            }
                        },
                    @endforeach
                ]
            });

            const slugify = str =>
                str
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            $('#name').on('keyup', function() {
                $('#slug').val(slugify($(this).val()));
            });
            @error('slug')
                $('#slug').attr('readonly', false);
            @enderror

            $(document).ready(function() {
                setTimeout(function() {
                    $('.alert-error').fadeOut('slow');
                }, 5000); // waktu dalam milidetik sebelum alert menghilang
            });
        </script>
    @endpush
</x-app-layout>
