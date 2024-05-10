<x-app-layout>
    <x-slot name="title">
        Gallery
    </x-slot>

    <x-slot name="breadcrumb">
        <div class="d-flex justify-content-between align-content-center">New Image
            <a href="{{ route('admin.galleries.index') }}" style="font-size: 15px">
                <i class='bx bx-arrow-back'></i> Back to Gallery
            </a>
        </div>
    </x-slot>

    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            @csrf
            <div class="col">
                @if ($errors->any())
                    <div class="alert alert-danger alert-error">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-4 card">
                    <div class="card-header">
                        <h5 class="m-0 card-title">Tambah Gambar</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4 row">
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <label for="name" class="form-label">Title <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Image Title" required />
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <label for="name" class="form-label">Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug"
                                        placeholder="Auto generated" readonly>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">
                                <div class="form-group">
                                    <label for="desc" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select name="status" class="form-control form-select" id="status" required>
                                        <option value="0" {{ old('status') === false ? 'selected' : '' }}>Draft
                                        <option value="1" {{ old('status') ? 'selected' : '' }}>Published</option>
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-4 col">
                                <label for="image" class="form-label">Image <span
                                        class="text-danger">*</span></label>
                                <div class="alert alert-info">
                                    Bisa upload file hingga 3 files dengan total ukuran 9 MB
                                </div>
                                <input type="file" multiple name="gallery[]" id="gallery" required />
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

            // Create a FilePond instance
            const pond = FilePond.create(inputElement, {
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
                maxFiles: 3, // set maximum number of files to 3
                maxTotalFileSize: '9MB', // set total file size limit to 9MB
                server: {
                    url: "{{ route('admin.upload', ['model' => 'gallery', 'multiple' => true]) }}",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
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
