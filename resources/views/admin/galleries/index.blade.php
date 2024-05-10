<x-app-layout>
    <x-slot name="title">
        Gallery
    </x-slot>

    <x-slot name="breadcrumb">
        <div class="d-flex justify-content-between align-content-center">Gallery
            @can('galleries.create')
                <button id="create-btn" class="btn btn-primary">
                    Tambah Gambar
                </button>
            @endcan
        </div>
    </x-slot>

    {{-- @push('styles')
        <style>
            img {
                width: 200px;
                height: 200px;
                object-fit: cover;
            }

            /* Ukuran gambar pada tampilan mobile */
            @media (max-width: 767.98px) {
                .carousel .carousel-inner .carousel-item img {
                    width: 100%;
                    height: auto;
                    object-fit: cover;
                }
            }
        </style>
    @endpush --}}
        @push('styles')
        <style>
            .img-container {
                position: relative;
            }

            .delete-btn {
                display: none;
                position: absolute;
                top: 10px;
                right: 20px;
                z-index: 2;
            }

            .img-container:hover .delete-btn {
                display: block;
            }

        </style>
        @endpush
    <form id="uploadForm" action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" style="display: none">
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
                        <h5 class="m-0 card-title">Upload Gambar</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-4 col">
                                <label for="image" class="form-label">Image <span
                                        class="text-danger">*</span></label>
                                <div class="alert alert-info">
                                    Bisa upload file hingga 3 file sekaligus dengan total ukuran max 9 MB
                                </div>
                                <input type="file" multiple name="gallery[]" id="gallery" required />
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-primary">Simpan</button>
                            <button class="btn btn-secondary" id="close-btn">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr class="mt-2 mb-5">
    </form>
    <div class="row">
        @forelse ($galleries as $gallery)
        <div class="mb-3 col-md-4 img-container" style="max-height: 300px; overflow: hidden;">
            <img src="{{ $gallery->getFirstMediaUrl('gallery') }}" class="img-thumbnail" alt="...">
            <button type="button" class="btn btn-icon btn-danger delete-btn" onclick="deleteGallery('{{ route('admin.galleries.destroy', $gallery->id) }}')"><i class="bx bx-trash"></i></button>
        </div>
        @empty
        <div class="col">
            <div class="alert alert-secondary">
                There no record found
            </div>
        </div>
        @endforelse
    </div>
    @can('galleries.delete')
    <form method="POST" id="deleteForm" action="">
        @csrf
        @method('DELETE')

    </form>
    @endcan
    {{-- <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title d-flex justify-content-between align-content-center">
                        Gallery
                    </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Image</td>
                                    <td>Title</td>
                                    <td>Status</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($galleries as $gallery)
                                    <tr>
                                        <td>
                                            <div id="carouselExampleControls-{{ $gallery->id }}" class="carousel slide"
                                                data-bs-ride="carousel" data-bs-interval="false">
                                                <div class="carousel-inner">
                                                    @foreach ($gallery->getMedia('gallery') as $key => $media)
                                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                                            <img class="d-block w-100" src="{{ $media->getUrl() }}"
                                                                alt="{{ $media->name }}">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                @if (count($gallery->getMedia('gallery')) > 1)
                                                    <button class="carousel-control-prev" type="button"
                                                        data-bs-target="#carouselExampleControls-{{ $gallery->id }}"
                                                        data-bs-slide="prev">
                                                        <span class="carousel-control-prev-icon"
                                                            aria-hidden="true"></span>
                                                        <span class="visually-hidden">Previous</span>
                                                    </button>
                                                    <button class="carousel-control-next" type="button"
                                                        data-bs-target="#carouselExampleControls-{{ $gallery->id }}"
                                                        data-bs-slide="next">
                                                        <span class="carousel-control-next-icon"
                                                            aria-hidden="true"></span>
                                                        <span class="visually-hidden">Next</span>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $gallery->name }}</td>
                                        <td>
                                            @if ($gallery->status == 0)
                                                <span class="badge bg-label-warning me-1">Draft</span>
                                            @elseif ($gallery->status == 1)
                                                <span class="badge bg-label-success me-1">Published</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="text-nowrap">
                                                <a class="ul-link-action text-warning"
                                                    href="{{ route('admin.galleries.edit', $gallery->id) }}"
                                                    data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="bx bx-edit"></i></a>
                                                <button onclick="deleteGallery(this.dataset.url)"
                                                    data-url="{{ route('admin.galleries.destroy', $gallery->id) }}"
                                                    class="btn btn-sm btn-icon text-danger delete-record"
                                                    data-toggle="tooltip" data-placement="top" title="Hapus">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            There no record
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
                </div>
                <div class="pb-0 card-footer">
                    {{ $galleries->links() }}
                </div>
            </div>
        </div>
    </div> --}}

    @can('galleries.create')
        @push('scripts')
            <script>
                $('#create-btn').click(function() {
                    $('#uploadForm').show();
                });

                $('#close-btn').click(function() {
                    $('#uploadForm').hide();
                });
            </script>
        @endpush
    @endcan

    @push('scripts')
        <link rel="stylesheet" href="{{ asset('admin/libs/sweetalert/sweetalert2.css') }}">
        </link>
        <script src="{{ asset('admin/libs/sweetalert/sweetalert2.js') }}"></script>

        <script>
            @if (session('success'))
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'Ok'
                })
            @endif

            function deleteGallery(url) {
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
