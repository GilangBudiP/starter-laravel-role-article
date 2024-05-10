<x-app-layout>
    <x-slot name="title">
        Edit Menu
    </x-slot>

    <x-slot name="breadcrumb">
        <div class="d-flex justify-content-between align-content-center">Edit Menu
            <a href="{{ route('admin.restaurants.edit', $restaurant->id) }}" style="font-size: 15px">
                <i class='bx bx-arrow-back'></i> Back
            </a>
        </div>
    </x-slot>

    <form action="{{ route('admin.menus.update', ['restaurant_id' => $restaurant->id, 'menu_id' => $menu->id]) }}"
        method="POST" enctype="multipart/form-data">
        <div class="row">
            @csrf
            @method('PUT')
            <div class="col">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title m-0">Tambah Menu</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Nama Menu<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Nama Menu" required value="{{ $menu->name }}" />
                                </div>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Slug<a
                                            class="ms-2 text-warning fw-semibold" href="#!"
                                            onclick="$('#slug').attr('readonly', false)">Edit</a></label>
                                    <input type="text" class="form-control" name="slug" id="slug"
                                        placeholder="Auto generated or choose your own" readonly
                                        value="{{ $menu->slug }}">
                                </div>

                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Harga<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="price" id="price" class="form-control input-price"
                                        placeholder="Harga" required value="{{ $menu->price }}" />
                                </div>
                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col md-6">
                                <div class="form-group">
                                    <label for="desc" class="form-label">Menu Type<span
                                            class="text-danger">*</span></label>
                                    <select name="type" class="form-control form-select" id="type">
                                        <option>Select Menu Type</option>
                                        <option value="1" {{ $menu->type === 1 ? 'selected' : '' }}>
                                            Makanan</option>
                                        <option value="0" {{ $menu->type === 0 ? 'selected' : '' }}>Minuman
                                        </option>
                                        </option>
                                    </select>
                                </div>
                                @error('type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-4">
                                <label for="image" class="form-label">Gambar<span
                                        class="text-danger">*</span></label>
                                <input type="file" class="filepond" id="cover" name="cover"
                                    value="{{ $menu->getFirstMediaUrl('cover') }}">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col md-6">
                                <label for="desc" class="form-label">Deskripsi Menu<span
                                        class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control" cols="30" rows="10" required>{{ $menu->seo->description }}</textarea>
                            </div>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
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
            var cleave = new Cleave('.input-price', {
                numeral: true,
                prefix: 'Rp ',
                signBeforePrefix: true,
                numeralThousandsGroupStyle: 'thousand'
            });

            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateSize, FilePondPluginFileValidateType);
            const inputElement = document.querySelector('input[id="cover"]');

            // Create a FilePond instance
            const pond = FilePond.create(inputElement);
            pond.setOptions({
                allowImagePreview: true,
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
                maxFileSize: '1MB',
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
                            "{{ route('admin.menus.destroy-image', ['menu' => $menu->id, 'image' => ':id']) }}";
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
                files: [{
                    source: '{{ $menu->getFirstMediaUrl('cover') }}',
                    options: {
                        type: 'local',
                    }
                }, ]
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
        </script>
    @endpush
</x-app-layout>
