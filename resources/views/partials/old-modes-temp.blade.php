
  <!-- MODES PRODUCTS -->
  @foreach($modes as $k => $mode)
    <section class="modes-products">
      <div class="container">
        <h2>{{ $mode->title }}</h2><br>
        @foreach($mode->products->where('status', 1)->take(16)->chunk(8) as $key => $chunk)
          <div class="fade @if($key == 0) show active @endif">
            <div class="xs-tab-slider owl-carousel -row category-v4">
              @foreach($chunk as $product)
                <div class="xs-tab-slider-item -col-lg-3 -col-md-6 -col-xs-6">
                  <div class="xs-product-wraper version-3 text-center">
                    <a href="/goods/{{ $product->id.'-'.$product->slug }}">
                      <img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->title }}">
                    </a>
                    <div class="offer">
                      @foreach($product->modes as $m)
                        @if(in_array($m->slug, ['novelty', 'best-price', 'stock', 'plus-gift']))
                          <div class="offer-{{ $m->slug }}">{{ $m->title }}</div>
                        @endif
                      @endforeach
                    </div>
                    <div class="xs-product-content">
                      <h4 class="product-title"><a href="/goods/{{ $product->id.'-'.$product->slug }}">{{ $product->title }}</a></h4>
                      <span class="price"><b>{{ $product->price }}〒</b></span>

                      @if (is_array($favorites) AND in_array($product->id, $favorites['products_id']))
                        <button type="button" class="btn btn-dark btn-compact m-10 btn-sm" data-favorite-id="{{ $product->id }}" onclick="toggleFavorite(this);" title="Добавлено в избранные"><span class="icon icon-heart h5"></span></button>
                      @else
                        <button type="button" class="btn btn-outline-primary btn-compact m-10 btn-sm" data-favorite-id="{{ $product->id }}" onclick="toggleFavorite(this);" title="Добавить в избранные"><span class="icon icon-heart h5"></span></button>
                      @endif

                      @if (is_array($items) AND isset($items['products_id'][$product->id]))
                        <a href="/basket" class="btn btn-dark btn-compact m-10" data-toggle="tooltip" data-placement="top" title="Перейти в корзину"><i class="icon icon-bag h5"></i></a>
                      @else
                        <button class="btn btn-primary btn-compact m-10 btn-sm" data-basket-id="{{ $product->id }}" onclick="addToBasket(this);" title="Добавить в корзину"><span class="icon icon-cart h5"></span></button>
                      @endif
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endforeach
      </div>
    </section>
  @endforeach
