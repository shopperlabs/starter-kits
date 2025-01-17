<?php

declare(strict_types=1);

use App\Models\Category;
use function Livewire\Volt\state;

state([
    'categories' => once(
        fn () => Category::isRoot()->scopes(['enabled'])->get()
    ),
]);

?>

<div class="hidden items-center gap-x-6 lg:flex">
    @foreach ($categories as $category)
        <x-nav.item href="#">{{ $category->name }}</x-nav.item>
    @endforeach
</div>
