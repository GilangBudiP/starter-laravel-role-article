<x-app-layout>
    <x-slot name="title">
        Resto & Menu
    </x-slot>

    <x-slot name="breadcrumb">
        Manage Resto
    </x-slot>

    @push('styles')
        <style>
            img {
                width: 200px;
                height: 200px;
                object-fit: cover;
            }
        </style>
    @endpush

    <div class="accordion mb-4" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                    aria-expanded="true" aria-controls="collapseOne">
                    <h5 class="my-0">Edit Restaurant Info</h5>
                </button>
            </h2>
            <form action="{{ route('admin.restaurants.update', $restaurant->id) }}" method="POST"
                enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="row mb-4 g-4">
                            <div class="col-md-12">
                                <label for="image" class="form-label">Gambar</label>
                                <input type="file" class="filepond" id="cover" name="cover">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Nama Resto</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ old('name', $restaurant->name) }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug"
                                        placeholder="Auto generated or choose your own" readonly
                                        value="{{ $restaurant->slug }}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="name" class="form-label">Telephone</label>
                                    <input type="number" name="telephone" id="telephone"
                                        class="form-control  @error('telephone') is-invalid @enderror"
                                        placeholder="08XXXXX" value="{{ old('telephone', $restaurant->telephone) }}"
                                        required />
                                    @error('telephone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-12">
                                <label for="desc" class="form-label">About Resto</label>
                                <textarea name="description" id="description" class="form-control" cols="30" rows="10" required>{{ $restaurant->seo->description }}</textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title d-flex justify-content-between align-items-center">
                        Menu Resto
                        <a href="{{ route('admin.menus.create', $restaurant->id) }}" class="btn btn-primary my-3">
                            <i class='bx bx-plus'></i> Tambah Menu
                        </a>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <td>Image</td>
                                    <td>Nama</td>
                                    <td>Harga</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menus as $menu)
                                    <tr>
                                        <td> <img src="{{ $menu->getFirstMediaUrl('cover') }}"
                                                alt="{{ $menu->name }}">
                                        </td>
                                        <td>{{ $menu->name }}</td>
                                        <td>{{ $menu->price }}</td>
                                        <td> <span class="text-nowrap">
                                                <a class="ul-link-action text-warning"
                                                    href="{{ route('admin.menus.edit', ['restaurant' => $restaurant->id, 'menu' => $menu->id]) }}"
                                                    data-toggle="tooltip" data-placement="top" title="Edit">
                                                    <i class="bx bx-edit"></i></a>
                                                <button onclick="deleteMenu(this.dataset.url)"
                                                    data-url="{{ route('admin.menus.destroy', $menu->id) }}"
                                                    class="btn btn-sm btn-icon text-danger delete-record"
                                                    data-toggle="tooltip" data-placement="top" title="Hapus">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                            </span></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <form method="POST" id="deleteForm" action="">
                            @csrf
                            @method('DELETE')

                        </form>
                    </div>
                </div>
                <div class="card-footer pb-0">
                    {{ $menus->links() }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateSize, FilePondPluginFileValidateType);
            const inputElement = document.querySelector('input[id="cover"]');

            // Create a FilePond instance
            const pond = FilePond.create(inputElement);
            pond.setOptions({
                allowImagePreview: true,
                maxFileSize: '2MB',
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
                server: {
                    process: {
                        url: "{{ route('admin.upload', 'cover') }}",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                    },
                    revert: {
                        url: "{{ route('admin.upload.destroy', 'cover') }}",
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            '_method': 'DELETE',
                        },
                    },
                    load: (uniqueFileId, load) => {
                        console.log(uniqueFileId);
                        fetch(uniqueFileId)
                            .then(res => res.blob())
                            .then(load);
                    },
                    remove: (source, load) => {
                        var id = source.split('/').slice(-2)[0];
                        var url =
                            "{{ route('admin.restaurants.destroy-image', ['restaurant' => $restaurant->id, 'image' => ':id']) }}";
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
                @if ($restaurant->getFirstMediaUrl('cover') != '')
                    files: [{
                        source: '{{ $restaurant->getFirstMediaUrl('cover') }}',
                        options: {
                            type: 'local',
                        }
                    }, ]
                @endif
            });

            function deleteMenu(url) {
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
        </script>
    @endpush
</x-app-layout>
