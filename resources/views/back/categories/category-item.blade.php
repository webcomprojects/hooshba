<li class="dd-item" data-id="{{ $category['id'] }}">
    <div class="dd-handle">{{ $category['name'] }}</div>

    @if (!empty($category['children']))
        <ol class="dd-list">
            @foreach ($category['children'] as $child)
                @include('back.categories.category-item', ['category' => $child])
            @endforeach
        </ol>
    @endif
</li>