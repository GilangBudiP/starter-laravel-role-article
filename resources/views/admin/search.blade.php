<x-app-layout>
    <x-slot name="breadcrumb">
        Hasil Pencarian
    </x-slot>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="card-title">
                        {{ $searchResults->count() }} results found for "{{ request('search') }}"
                    </h5>
                </div>
                <div class="table-responsive table-nowrap">
                    <table class="table">
                        <thead>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Link</th>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse ($searchResults->groupByType() as $type => $modelSearchResults)
                                <tr>
                                    <td colspan="3">
                                        <span class="fw-bold">{{ ucfirst($type) }}</span>
                                    </td>
                                </tr>
                                @foreach ($modelSearchResults as $searchResult)
                                <tr>
                                    <td>{{ $searchResult->title }}</td>
                                    <td>{{ $searchResult->type }}</td>
                                    <td><a href="{{ $searchResult->url }}">Link</a></td>
                                </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="3" align="center">
                                        Data tidak ditemukan, coba pakai kata kunci yang lain
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
