<x-app-layout>
    <x-slot name="title">
        Tulis Artikel
    </x-slot>

    <x-slot name="breadcrumb">
        Tulis Artikel
    </x-slot>

    <form action="{{ route('admin.articles.store') }}" class="row" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-8 mb-3 mb-lg-0">
            <div class="card mb-3 mb-lg-5">
                <div class="card-header">
                    <h4 class="card-title">
                        Tulis Artikel
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col md-6">
                            <div class="mb-4 form-group">
                                <label for="title" class="form-label">Title <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control  @error('title') is-invalid @enderror"
                                    id="title" name="title" required value="{{ old('title') }}">
                                @error('title')
                                    <p>{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="col md-6">
                            <div class="form-group">
                                <label for="title" class="form-label">Slug<a class="ms-2 text-warning fw-semibold"
                                        href="#!" onclick="$('#slug').attr('readonly', false)">Edit</a></label>
                                <input type="text" class="form-control" name="slug" id="slug"
                                    placeholder="Auto generated or choose your own" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- End Form -->
                    <div class="mb-4 form-group">
                        <label for="cover" class="form-label">Cover <span class="text-danger">*</span></label>
                        <input type="file" class="filepond" id="cover" name="cover" required>
                    </div>
                    <div class="mb-4 form-group">
                        <label class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea name="description" id="description" cols="30" rows="5"
                            class="form-control mb-4 @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                        @error('description')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-4 form-group">
                        <label class="form-label">Content <span class="text-danger">*</span></label>
                        <textarea name="body" id="body" rows="5">{{ old('body') }}</textarea>
                        @error('body')
                            <p>{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <!-- End Card -->
            </div>
            <!-- End Col -->
        </div>

        <div class="col-lg-4 sticky-top">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <!-- Form -->
                    <div class="form-group mb-4">
                        <label for="category" class="form-label">Category <span class="text-danger">*</span></label>
                        <div class="tom-select-custom">
                            <select class="form-control form-select" autocomplete="off" name="category_id"
                                id="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="form group mb-4">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <div class="tom-select-custom">
                            <select name="status" class="form-control form-select" id="status" required>
                                <option value="">Select Status</option>
                                <option value="1" {{ old('status') ? 'selected' : '' }}>Published</option>
                                <option value="0" {{ old('status') === false ? 'selected' : '' }}>Draft</option>
                            </select>
                            @error('status')
                                <p>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <!-- Body -->
                </div>
                <!-- End Card -->
            </div>
            <!-- End Col -->
        </div>
    </form>

    @push('scripts')
        <script>
            class MyUploadAdapter {
                constructor(loader) {
                    // The file loader instance to use during the upload. It sounds scary but do not
                    // worry — the loader will be passed into the adapter later on in this guide.
                    this.loader = loader;
                }
                // Starts the upload process.
                upload() {
                    return this.loader.file
                        .then(file => new Promise((resolve, reject) => {
                            this._initRequest();
                            this._initListeners(resolve, reject, file);
                            this._sendRequest(file);
                        }));
                }
                // Aborts the upload process.
                abort() {
                    if (this.xhr) {
                        this.xhr.abort();
                    }
                }
                // Initializes the XMLHttpRequest object using the URL passed to the constructor.
                _initRequest() {
                    const xhr = this.xhr = new XMLHttpRequest();
                    // Note that your request may look different. It is up to you and your editor
                    // integration to choose the right communication channel. This example uses
                    // a POST request with JSON as a data structure but your configuration
                    // could be different.
                    xhr.open('POST', '{{ route('admin.images.store') }}', true);
                    xhr.setRequestHeader('x-csrf-token', '{{ csrf_token() }}');
                    xhr.responseType = 'json';
                }
                // Initializes XMLHttpRequest listeners.
                _initListeners(resolve, reject, file) {
                    const xhr = this.xhr;
                    const loader = this.loader;
                    const genericErrorText = `Couldn't upload file: ${ file.name }.`;
                    xhr.addEventListener('error', () => reject(genericErrorText));
                    xhr.addEventListener('abort', () => reject());
                    xhr.addEventListener('load', () => {
                        const response = xhr.response;
                        // This example assumes the XHR server's "response" object will come with
                        // an "error" which has its own "message" that can be passed to reject()
                        // in the upload promise.
                        //
                        // Your integration may handle upload errors in a different way so make sure
                        // it is done properly. The reject() function must be called when the upload fails.
                        if (!response || response.error) {
                            return reject(response && response.error ? response.error.message : genericErrorText);
                        }
                        // If the upload is successful, resolve the upload promise with an object containing
                        // at least the "default" URL, pointing to the image on the server.
                        // This URL will be used to display the image in the content. Learn more in the
                        // UploadAdapter#upload documentation.
                        resolve({
                            default: response.url
                        });
                    });
                    // Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
                    // properties which are used e.g. to display the upload progress bar in the editor
                    // user interface.
                    if (xhr.upload) {
                        xhr.upload.addEventListener('progress', evt => {
                            if (evt.lengthComputable) {
                                loader.uploadTotal = evt.total;
                                loader.uploaded = evt.loaded;
                            }
                        });
                    }
                }
                // Prepares the data and sends the request.
                _sendRequest(file) {
                    // Prepare the form data.
                    const data = new FormData();
                    data.append('upload', file);
                    // Important note: This is the right place to implement security mechanisms
                    // like authentication and CSRF protection. For instance, you can use
                    // XMLHttpRequest.setRequestHeader() to set the request headers containing
                    // the CSRF token generated earlier by your application.
                    // Send the request.
                    this.xhr.send(data);
                }
                // ...
            }

            function SimpleUploadAdapterPlugin(editor) {
                editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                    // Configure the URL to the upload script in your back-end here!
                    console.log(loader);
                    return new MyUploadAdapter(loader);
                };
            }
            ClassicEditor
                .create(document.querySelector('#body'), {
                    extraPlugins: [SimpleUploadAdapterPlugin],
                    mediaEmbed: {
                        previewsInData: true
                    }
                })
                .catch(error => {
                    console.error(error);
                });



            //Get a reference to the file input element
            FilePond.registerPlugin(
                FilePondPluginImagePreview,
                FilePondPluginFileValidateSize,
                FilePondPluginFileValidateType
            );
            const inputElement = document.querySelector('input[id="cover"]');

            // Create a FilePond instance
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
                },
            });



            const slugify = str =>
                str
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            $('#title').on('keyup', function() {
                $('#slug').val(slugify($(this).val()));
            });
            @error('slug')
                $('#slug').attr('readonly', false);
            @enderror
        </script>
    @endpush
</x-app-layout>
