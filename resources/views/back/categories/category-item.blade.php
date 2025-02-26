<li class="dd-item" data-id="{{ $category['id'] }}">
    <div class="dd-handle">
        <span>{{ $category['name'] }}</span>

    </div>
    <span class="operation-category-item">
        <span data-bs-toggle="modal" data-bs-target="#edit-category-modal" data-data="{{ route('back.categories.edit', $category['id']) }}" data-action="{{ route('back.categories.update', $category['id']) }}" class=" fas fa-pen edit-category-item"></span>
        <span data-bs-toggle="modal" data-bs-target="#delete-modal"
            data-action="{{ route('back.categories.destroy', $category['id']) }}"
            class=" btn-danger delete-modal fas fa-trash-can remove-category-item"></span>
    </span>
    @if (!empty($category['children']))
        <ol class="dd-list dd-list-child">
            @foreach ($category['children'] as $child)
                @include('back.categories.category-item', ['category' => $child])
            @endforeach
        </ol>
    @endif
</li>
