<x-app-layout>
    <x-slot name="title">
        Resto
    </x-slot>

    <x-slot name="breadcrumb">
        Restoran
    </x-slot>


    <div class="row">
        @foreach ($restaurants as $resto)
            <div class="col-sm-6 mb-3">
                <div class="card">
                    <img src="{{ $resto->getFirstMediaUrl('cover') != '' ? $resto->getFirstMediaUrl('cover') : 'https://via.placeholder.com/150' }}"
                        class="card-img-top" alt="..." style="object-fit:cover;max-height:250px;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $resto->name }}</h5>
                        <p class="card-text">{{ Str::limit($resto->seo->description, 130) }}</p>
                        <a href="{{ route('admin.restaurants.edit', $resto->id) }}" class="btn btn-primary">Manage Resto
                            & Menus</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</x-app-layout>
