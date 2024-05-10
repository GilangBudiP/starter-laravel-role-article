<x-app-layout>
    <x-slot name="title">
        Tulis Artikel
    </x-slot>

    <x-slot name="breadcrumb">
        <span class="text-muted fw-light">Artikel /</span> Preview
    </x-slot>

    <div class="card overflow-hidden mb-3">
        <div class="cover-image overflow-hidden">
            <img class="card-img-top" src="{{ $article->getFirstMediaUrl('cover') }}" alt="">
        </div>
        <div class="card-body">
            <div class="row justify-content-between align-items-center">
                <div class="col">
                    <div class="d-flex">
                        <div class="flex-1 fs--1">
                            <h5 class="fs-0">{{ $article->title }}</h5>
                            <p class="mb-0">by {{ $article->user->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body ck-content">
            {!! $article->body !!}
        </div>
    </div>
</x-app-layout>
