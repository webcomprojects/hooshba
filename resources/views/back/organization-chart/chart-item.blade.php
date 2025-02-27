<li class="dd-item" data-id="{{ $chart['id'] }}">
    <div class="dd-handle">
        <span>{{ $chart['name'] }}</span>

    </div>

    <span class="operation-category-item">
        <span data-bs-toggle="modal" data-bs-target="#edit-category-modal" data-data="{{ route('back.about-us.organization-chart.edit', $chart['id']) }}" data-action="{{ route('back.about-us.organization-chart.update', $chart['id']) }}" class=" fas fa-pen edit-category-item"></span>
        <span data-bs-toggle="modal" data-bs-target="#delete-modal"
            data-action="{{ route('back.about-us.organization-chart.destroy', $chart['id']) }}"
            class=" btn-danger delete-modal fas fa-trash-can remove-category-item"></span>
    </span>
    @if (!empty($chart['children']))
        <ol class="dd-list dd-list-child">
            @foreach ($chart['children'] as $child)
                @include('back.organization-chart.chart-item', ['chart' => $child])
            @endforeach
        </ol>
    @endif
</li>
