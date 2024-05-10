<x-app-layout>
    <x-slot name="title">
        Artikel
    </x-slot>

    <x-slot name="breadcrumb">
        <span class="text-muted fw-light">Artikel /</span> Artikel
    </x-slot>

    <div class="row">
        <div class="col">
            <div class="card">
                <h5 class="card-header d-flex justify-content-between align-items-center">
                    Artikel
                    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary my-3"><i
                            class='bx bx-pencil'></i>
                        Tulis Artikel
                    </a>
                </h5>
                <div class="card-body table-responsive">
                    <table id="articleList" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Author</th>
                                <th>Created Date</th>
                                <th>Updated Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($articles as $article)
                                <tr>
                                    <td>{{ $article->title }}</td>
                                    <td>{{ Str::limit($article->seo->description, 150) }}</td>
                                    <td>
                                        @if ($article->status == 0)
                                            <span class="badge bg-label-warning me-1">Draft</span>
                                        @elseif ($article->status == 1)
                                            <span class="badge bg-label-success me-1">Published</span>
                                        @endif
                                    </td>
                                    <td>{{ $article->user->name }}</td>
                                    <td>{{ $article->created_at->format('d M Y') }}</td>
                                    <td>{{ $article->updated_at->format('d M Y') }}</td>
                                    <td>
                                        <span class="text-nowrap">
                                            <a class="ul-link-action text-info"
                                                href="{{ route('admin.articles.show', $article->id) }}"
                                                data-toggle="tooltip" data-placement="top" title="Preview">
                                                <i class='bx bx-spreadsheet'></i></a>
                                            <a class="ul-link-action text-warning"
                                                href="{{ route('admin.articles.edit', $article->id) }}"
                                                data-toggle="tooltip" data-placement="top" title="Edit">
                                                <i class="bx bx-edit"></i></a>
                                            <button onclick="deleteArticle(this.dataset.url)"
                                                data-url="{{ route('admin.articles.destroy', $article->id) }}"
                                                class="btn btn-sm btn-icon text-danger delete-record"
                                                data-toggle="tooltip" data-placement="top" title="Hapus">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                {{-- <tr>
                                    <td colspan="7" class="text-center">
                                        Article data not found
                                    </td>
                                </tr> --}}
                            @endforelse
                        </tbody>
                    </table>
                    <form method="POST" id="deleteForm" action="">
                        @csrf
                        @method('DELETE')

                    </form>
                </div>
            </div>
        </div>
    </div>

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

            function deleteArticle(url) {
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

            $(document).ready(function() {
                $('#articleList').DataTable({
                    "paging": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "order": [
                        [5, "desc"]
                    ],
                    // "lengthChange": false,
                    "pageLength": 10,
                    "columnDefs": [{
                        "orderable": false,
                        "targets": [0, 1, 2, 3, 6]
                    }]
                });
            });
        </script>
    @endpush
</x-app-layout>
