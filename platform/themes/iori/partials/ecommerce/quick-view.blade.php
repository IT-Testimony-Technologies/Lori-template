@if ($product)
    <section class="section">
        <div class="container product-details">
            <div class="row">
                <div class="col-lg-6 text-center mb-10">
                    <div class="detail-gallery">
                        <img src="{{ RvMedia::getImageUrl($product->image) }}" alt="{{ $product->name }}">
                    </div>
                </div>
                <div class="col-lg-6 mb-30">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="box-category-product">
                            @foreach ($product->categories as $category)
                                <span class="tag-category">{{ $category->name }}@if (!$loop->last),&nbsp;@endif</span>
                            @endforeach
                        </div>
                        @if (EcommerceHelper::isReviewEnabled())
                            <a href="{{ $product->url }}#review-tab" class="anchor-link">
                                <div class="d-flex">
                                    <a href="{{ $product->url }}#review-tab">
                                        <div class="product-rate d-inline-block me-2">
                                            <div class="product-rating" style="width: {{ $product->reviews_avg * 20 }}%;"></div>
                                        </div>
                                    </a>
                                    <span class="text-semibold">
                                        <span>({{ number_format($product->reviews_count) }})</span>
                                    </span>
                                </div>
                            </a>
                        @endif
                    </div>
                    <a href="{{ $product->url }}" class="color-gray-800 mt-20 mb-20 text-heading-3">{{ $product->name }}</a>
                    <div class="d-flex align-items-center mb-20 box-price-banner box-price">
                        @if ($product->front_sale_price === $product->price)
                            <h3 class="color-success mr-20 price">{{ format_price($product->front_sale_price_with_taxes) }}</h3>
                        @else
                            <h3 class="color-success mr-20 price">{{ format_price($product->front_sale_price_with_taxes) }}</h3>
                            <h4 class="color-grey-400 price-old mr-20">{{ format_price($product->price_with_taxes) }}</h4>
                        @endif

                        @if ($stockStatusLabel = $product->stockStatusLabel)
                            <p class="font-md color-grey-400">({{ $stockStatusLabel }})</p>
                        @endif
                    </div>
                    <div class="mb-20">
                        {!! BaseHelper::clean(Str::limit($product->description, 300)) !!}
                    </div>

                    <form class="cart-form" action="{{ route('public.cart.add-to-cart') }}" method="POST">
                        @csrf

                        @if ($product->variations()->count() > 0)
                            <div class="pr_switch_wrap">
                                {!! render_product_swatches($product, [
                                    'selected' => $selectedAttrs,
                                    'view'     => Theme::getThemeNamespace('views.ecommerce.attributes.swatches-renderer')
                                ]) !!}
                            </div>
                            <div class="number-items-available" style="display: none; margin-bottom: 10px;"></div>
                        @endif

                        <input type="hidden"
                               name="id" class="hidden-product-id"
                               value="{{ $product->id }}"/>
                        <input type="hidden" name="qty" value="1">
                        <div class="form-actions">
                            <div class="box-quantity">
                                <div class="form-quantity mr-10">
                                    <input class="input-quantity" min="1" type="text" value="1">
                                    <span class="button-quantity button-up" data-type="increase"></span>
                                    <span class="button-quantity button-down" data-type="decrease"></span>
                                </div>
                            </div>
                            <button type="submit" @class(['btn btn-brand-1 mr-10 btn-cart text-wrap', 'disable' => $product->isOutOfStock()])>{{ __('Add To Cart') }}</button>
                            @if (EcommerceHelper::isWishlistEnabled())
                                <a class="btn btn-brand-1 add-to-wishlist" href="{{ route('public.wishlist.add', $product->id) }}">
                                    <svg class="w-6 h-6 icon-16" stroke-width="2" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </a>
                            @endif

                            @if (EcommerceHelper::isCompareEnabled())
                                <a class="btn btn-brand-1 add-to-compare ms-2" href="{{ route('public.compare.add', $product->id) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6 icon-16">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </form>

                    <div class="box-categories-link mt-30">
                        <div class="item-cat meta-sku @if (!$product->sku) d-none @endif">
                            <span class="text-body color-gray-900 d-inline-block">{{ __('SKU') }}:&nbsp;</span>
                            <span class="text-body color-gray-500 meta-value d-inline-block">{{ $product->sku }}</span>
                        </div>
                        @if ($product->categories->count())
                            <div class="item-cat d-block">
                                <span class="text-body color-gray-900 d-inline-block">{{ __('Categories') }}:&nbsp;</span>
                                @foreach($product->categories as $category)
                                    <a href="{{ $category->url }}" class="text-body meta-value d-inline-block">{{ $category->name }}</a>@if (!$loop->last),&nbsp;@endif
                                @endforeach
                            </div>
                        @endif
                        @if ($product->tags->count())
                            <div class="item-cat d-block">
                                <span class="text-body color-gray-900 d-inline-block">{{ __('Tags') }}:&nbsp;</span>
                                @foreach($product->tags as $tag)
                                    <a href="{{ $tag->url }}" class="text-body meta-value d-inline-block">{{ $tag->name }}</a>@if (!$loop->last), @endif
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
