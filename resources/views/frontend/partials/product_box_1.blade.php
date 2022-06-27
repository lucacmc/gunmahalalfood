<div class="aiz-card-box border border-light rounded hov-shadow-md mt-1 mb-2 has-transition bg-white">
    @if(discount_in_percentage($product) > 0)
        <span class="badge-custom">{{ translate('OFF') }}<span class="box ml-1 mr-0">&nbsp;{{discount_in_percentage($product)}}%</span></span>
    @endif
    <div class="position-relative">
        @php
            $product_url = route('product', $product->slug);
            if($product->auction_product == 1) {
                $product_url = route('auction-product', $product->slug);
            }
        @endphp
        <a href="{{ $product_url }}" class="d-block">
            <img
                class="img-fit lazyload mx-auto h-140px h-md-210px"
                src="{{ static_asset('assets/img/placeholder.jpg') }}"
                data-src="{{ uploaded_asset($product->thumbnail_img) }}"
                alt="{{  $product->getTranslation('name')  }}"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
            >
        </a>
        @if ($product->wholesale_product)
            <span class="absolute-bottom-left fs-11 text-white fw-600 px-2 lh-1-8" style="background-color: #455a64">
                {{ translate('Wholesale') }}
            </span>
        @endif
        <div class="absolute-top-right aiz-p-hov-icon">
            <a href="javascript:void(0)" onclick="addToWishList({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to wishlist') }}" data-placement="left">
                <i class="la la-heart-o"></i>
            </a>
            <a href="javascript:void(0)" onclick="addToCompare({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to compare') }}" data-placement="left">
                <i class="las la-sync"></i>
            </a>
            <a href="javascript:void(0)" onclick="showAddToCartModal({{ $product->id }})" data-toggle="tooltip" data-title="{{ translate('Add to cart') }}" data-placement="left">
                <i class="las la-shopping-cart"></i>
            </a>
        </div>
    </div>
    <div class="p-md-3 p-2 text-left">
        <div class="fs-15">
            @if(home_base_price($product) != home_discounted_base_price($product))
                <del class="fw-600 opacity-50 mr-1">{{ home_base_price($product) }}</del>
            @endif
            <span class="fw-700 text-primary">{{ home_discounted_base_price($product) }}</span>
        </div>
        <div class="rating rating-sm mt-1">
            {{ renderStarRating($product->rating) }}
        </div>
        <h3 class="fw-600 fs-13 text-truncate-2 lh-1-4 mb-0 h-35px">
            <a href="{{ $product_url }}" class="d-block text-reset">{{  $product->getTranslation('name')  }}</a>
        </h3>
        @if (addon_is_activated('club_point'))
            <div class="rounded px-2 mt-2 bg-soft-primary border-soft-primary border">
                {{ translate('Club Point') }}:
                <span class="fw-700 float-right">{{ $product->earn_point }}</span>
            </div>
        @endif
        <div class="add_to_bag">

            @php
                $qty = 0;
                foreach ($product->stocks as $key => $stock) {
                    $qty += $stock->qty;
                }
            @endphp
            <form class="add-to-bag-form">
                @if($qty >0)
                    <a href="javascript:void(0)" class="addToBagSubmit">
                        <i class="las la-bolt"></i> {{ translate('Add to bag') }}
                    </a>
                @else
                    <a href="javascript:void(0)" class="btn btn-secondary out-of-stock fw-600" disabled>
                        <i class="la la-cart-arrow-down"></i>{{ translate('Out of Stock')}}
                    </a>
                @endif
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <!-- Quantity + Add to cart -->
                @if($product->digital !=1)
                    @if ($product->choice_options != null)
                        @foreach (json_decode($product->choice_options) as $key => $choice)

                            <div class="row no-gutters" style="display:none;">
                                <div class="col-2">
                                    <div
                                        class="opacity-50 mt-2 ">{{ \App\Models\Attribute::find($choice->attribute_id)->getTranslation('name') }}
                                        :
                                    </div>
                                </div>
                                <div class="col-10">
                                    <div class="aiz-radio-inline">
                                        @foreach ($choice->values as $key => $value)
                                            <label class="aiz-megabox pl-0 mr-2">
                                                <input
                                                    type="radio"
                                                    name="attribute_id_{{ $choice->attribute_id }}"
                                                    value="{{ $value }}"
                                                    @if($key == 0) checked @endif
                                                >
                                                <span
                                                    class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center py-2 px-3 mb-2">
                                                    {{ $value }}
                                                </span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    @if (count(json_decode($product->colors)) > 0)
                        <div class="row no-gutters" style="display: none">
                            <div class="col-2">
                                <div class="opacity-50 mt-2">{{ translate('Color')}}:</div>
                            </div>
                            <div class="col-10">
                                <div class="aiz-radio-inline">
                                    @foreach (json_decode($product->colors) as $key => $color)
                                        <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip"
                                               data-title="{{ \App\Models\Color::where('code', $color)->first()->name }}">
                                            <input
                                                type="radio"
                                                name="color"
                                                value="{{ \App\Models\Color::where('code', $color)->first()->name }}"
                                                @if($key == 0) checked @endif
                                            >
                                            <span
                                                class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                <span class="size-30px d-inline-block rounded"
                                                      style="background: {{ $color }};"></span>
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row no-gutters" style="display: none">
                        <div class="col-2">
                            <div class="opacity-50 mt-2">{{ translate('Quantity')}}:</div>
                        </div>
                        <div class="col-10">
                            <div class="product-quantity d-flex align-items-center">
                                <div class="row no-gutters align-items-center aiz-plus-minus mr-3"
                                     style="width: 130px;">
                                    <button class="btn col-auto btn-icon btn-sm btn-circle btn-light" type="button"
                                            data-type="minus" data-field="quantity" disabled="">
                                        <i class="las la-minus"></i>
                                    </button>
                                    <input type="number" name="quantity"
                                           class="col border-0 text-center flex-grow-1 fs-16 input-number"
                                           placeholder="1" value="{{ $product->min_qty }}" min="{{ $product->min_qty }}"
                                           max="10" lang="en">
                                    <button class="btn  col-auto btn-icon btn-sm btn-circle btn-light" type="button"
                                            data-type="plus" data-field="quantity">
                                        <i class="las la-plus"></i>
                                    </button>
                                </div>
                                <div class="avialable-amount opacity-60">
                                    @if($product->stock_visibility_state == 'quantity')
                                        (<span id="available-quantity">{{ $qty }}</span> {{ translate('available')}})
                                    @elseif($product->stock_visibility_state == 'text' && $qty >= 1)
                                        (<span id="available-quantity">{{ translate('In Stock') }}</span>)
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                @endif
                <div class="form-preloader text-center p-3" style="display: none;">
                    <i class="las la-spinner la-spin la-3x"></i>
                </div>
            </form>
        </div>
    </div>
</div>
