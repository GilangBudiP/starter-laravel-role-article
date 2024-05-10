<x-app-layout>
    <x-slot name="title">
        Menu
    </x-slot>

    <x-slot name="breadcrumb">
        <div class="d-flex justify-content-between align-content-center">New Menu
            <a href="{{ route('admin.restaurants.edit', $property->id) }}" style="font-size: 15px">
                <i class='bx bx-arrow-back'></i> Back
            </a>
        </div>
    </x-slot>

    <form action="{{ route('admin.menus.store', $property->id) }}" method="POST" enctype="multipart/form-data">
        <div class="row">
            @csrf
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
                                    <label for="name" class="form-label">Nama Menu <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name" id="name"
                                        class="form-control  @error('name') is-invalid @enderror"
                                        placeholder="Nama Menu" required />
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Slug</label>
                                    <input type="text" class="form-control" name="slug" id="slug"
                                        placeholder="Auto generated" readonly>
                                </div>
                                @error('slug')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col md-6">
                                <div class="form-group">
                                    <label for="name" class="form-label">Harga<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="price" id="price"
                                        class="form-control input-price  @error('price') is-invalid @enderror"
                                        placeholder="Harga" required />
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col md-6">
                                <div class="form-group">
                                    <label for="desc" class="form-label">Menu Type<span
                                            class="text-danger">*</span></label>
                                    <select name="type"
                                        class="form-control form-select @error('type') is-invalid @enderror"
                                        id="type">
                                        <option>Select Menu Type</option>
                                        <option value="1" {{ old('type') ? 'selected' : '' }}>Makanan</option>
                                        <option value="0" {{ old('type') === false ? 'selected' : '' }}>Minuman
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-4">
                                <label for="image" class="form-label">Gambar<span
                                        class="text-danger">*</span></label>
                                <input type="file" class="filepond" id="cover" name="cover" value="">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col md-6">
                                <label for="desc" class="form-label">Deskripsi Menu<span
                                        class="text-danger">*</span></label>
                                <textarea name="description" id="description" class="form-control" cols="30" rows="10" required></textarea>
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
            FilePond.setOptions({
                acceptedFileTypes: ['image/png', 'image/jpeg', 'image/jpg'],
                maxFileSize: '1MB',
                server: {
                    url: "{{ route('admin.upload', 'cover') }}",
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
        </script>
    @endpush
</x-app-layout>
