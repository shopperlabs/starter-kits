<div class="bg-white">
    <div class="pb-16 pt-10 sm:pb-24">
        <x-container class="mt-8 max-w-2xl">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-8">
                <div class="lg:col-span-3">
                    <aside class="space-y-10 lg:sticky lg:top-40" aria-labelledby="product-description">
                        <!-- Product details -->
                        <div>
                            <h2 class="text-sm font-medium text-gray-900">{{ __('Description') }}</h2>

                            <div class="prose prose-sm mt-4 text-gray-500">
                                {!! $product->description !!}
                            </div>
                        </div>

                        <x-product.additionnal-infos
                            :product="$product"
                            :categories="$product->categories->pluck('name')->join(', ')"
                        />
                    </aside>
                </div>

                <!-- Product gallery -->
                <div class="lg:col-span-6 lg:px-8">
                    <livewire:components.product.images
                        :thumbnail="$this->product->getFirstMediaUrl(config('shopper.media.storage.thumbnail_collection'))"
                        :images="$this->product->getMedia(config('shopper.media.storage.collection_name'))->map(function ($media) {
                            return $media->getUrl();
                        })->toArray()"
                    />
                </div>

                <div class="lg:col-span-3">
                    <aside class="space-y-10 lg:sticky lg:top-40" aria-labelledby="product-variant">
                        <livewire:components.variants-selector :$product />

                        <!-- Policies -->
                        <section aria-labelledby="policies-heading">
                            <h2 id="policies-heading" class="sr-only">{{ __('Our privacy') }}</h2>

                            <dl class="space-y-4">
                                <div class="border border-gray-200 bg-gray-50 p-6">
                                    <dt class="flex items-center gap-2">
                                        <x-untitledui-globe-05 class="size-6 text-gray-400" stroke-width="1.5" aria-hidden="true" />
                                        <span class="text-sm font-medium text-gray-900">{{ __('International delivery') }}</span>
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-500">
                                        {{ __('Get your order in 2 weeks') }}
                                    </dd>
                                </div>
                                <div class="border border-gray-200 bg-gray-50 p-6">
                                    <dt class="flex items-center gap-2">
                                        <x-untitledui-gift-02 class="size-6 text-gray-400" stroke-width="1.5" aria-hidden="true" />
                                        <span class="text-sm font-medium text-gray-900">{{ __('Loyalty rewards') }}</span>
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-500">
                                        {{ __('Don\'t look at other tees') }}
                                    </dd>
                                </div>
                            </dl>
                        </section>
                    </aside>
                </div>
            </div>
        </x-container>
    </div>
</div>
