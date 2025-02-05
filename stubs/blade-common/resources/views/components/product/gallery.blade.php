@props([
    'images',
])

<div class="grid grid-cols-2 gap-6">
    @foreach ($images as $image)
        <div class="h-[12.5rem] ring-1 ring-gray-100 overflow-hidden lg:h-[18.5rem] lg:w-full">
            <img
                src="{{ $image }}"
                alt=""
                class="size-full max-w-none object-cover object-center"
                loading="lazy"
            />
        </div>
    @endforeach
</div>
