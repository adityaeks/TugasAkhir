@php
    $popularCategories = json_decode($popularCategory->value, true);
    // dd($popularCategories)
@endphp
<section id="wsus__monthly_top" class="wsus__monthly_top_2">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                @if ($homepage_secion_banner_one->banner_one->status == 1)
                    <div class="wsus__monthly_top_banner">
                        <a href="{{ $homepage_secion_banner_one->banner_one->banner_url }}">
                            <img class="img-fluid"
                                src="{{ asset($homepage_secion_banner_one->banner_one->banner_image) }}" alt="">
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__section_header for_md">
                    <h3>Produk lagi populer</h3>
                    <div class="monthly_top_filter">

                        @php
                            $products = [];
                        @endphp
                        @foreach ($popularCategories as $key => $popularCategory)
                            @php
                                $lastKey = [];

                                foreach ($popularCategory as $key => $category) {
                                    if ($category === null) {
                                        break;
                                    }
                                    $lastKey = [$key => $category];
                                }

                                if (array_keys($lastKey)[0] === 'category') {
                                    $category = \App\Models\Category::find($lastKey['category']);
                                    $products[] = \App\Models\Product::where('category_id', $category->id)
                                        ->orderBy('id', 'DESC')
                                        ->take(12)
                                        ->get();
                                }
                            @endphp
                            <button class="{{ $loop->index === 0 ? 'auto_click active' : '' }}"
                                data-filter=".category-{{ $loop->index }}">{{ $category->name }}</button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-lg-12">
                <div class="row grid">
                    @foreach ($products as $key => $product)
                        @foreach ($product as $item)
                            <div class="col-xl-2 col-6 col-sm-6 col-md-4 col-lg-3  category-{{ $key }}">
                                <a class="wsus__hot_deals__single" href="{{ route('product-detail', $item->slug) }}">
                                    <div class="wsus__hot_deals__single_img">
                                        <img src="{{ asset($item->thumb_image) }}" alt="bag"
                                            class="img-fluid w-100">
                                    </div>
                                    <div class="wsus__hot_deals__single_text">
                                        <h5>{!! limitText($item->name) !!}</h5>
                                        <!-- Menghapus bagian rating -->

                                        @if (checkDiscount($item))
                                            <p class="wsus__tk">Rp{{ number_format($item->offer_price, 0, ',', '.') }}
                                                <del>Rp{{ number_format($item->price, 0, ',', '.') }}</del></p>
                                        @else
                                            <p class="wsus__tk">Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                        @endif

                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>
