<x-app-layout>
    <x-slot name="title">
        Dashboard Admin
    </x-slot>

    <div class="row">
        <div class="mb-4 col-md-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="flex-shrink-0 avatar">
                            <span class="text-info"><i class="bx bx-news bx-md"></i></span>
                        </div>
                        <div class="dropdown">
                            <button class="p-0 btn" type="button" id="cardDash2" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="bx bx-dots-vertical-rounded"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardDash2">
                                <a class="dropdown-item" href="{{ route('admin.articles.index') }}">Lihat Semua</a>
                            </div>
                        </div>
                    </div>
                    <span class="mb-1 fw-semibold d-block">Total Artikel</span>
                    <h3 class="mb-2 card-title">{{ $totalArticle }} Artikel</h3>
                    <small class="text-primary fw-semibold"> {{ $totalArticlePublished }} Artikel Publish</small>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
