@props([
    'images',
])

@foreach ($images as $image)
    <img
        src="{{ $image->getFullUrl() }}"
        alt="{{ $image->file_name }}"
        class="hidden lg:block"
        loading="lazy"
    />
@endforeach
