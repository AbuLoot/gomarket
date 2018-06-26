
  <!-- MODES PRODUCTS -->
  @foreach($modes as $k => $mode)
    <section class="modes-products">
      <div class="container">
        <h2>{{ $mode->title }}</h2><br>
        @foreach($mode->products->where('status', 1)->take(8)->chunk(4) as $key => $chunk)
          <div class="row">
            @foreach($chunk as $product)
              <div class="col-lg-3 col-md-6 col-xs-6">
                <div class="xs-product-wraper version-3 text-center">
                  <a href="/goods/{{ $product->id.'-'.$product->slug }}">
                    <img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->title }}">
                  </a>
                  @if(in_array($mode->slug, ['novelty', 'best-price', 'stock']))
                    <div class="offer">
                      <div class="offer-{{ $mode->slug }}">{{ $mode->title }}</div>
                    </div>
                  @endif
                  <div class="xs-product-content">
                    <h4 class="product-title"><a href="/goods/{{ $product->id.'-'.$product->slug }}">{{ $product->title }}</a></h4>
                    <span class="price"><b>{{ $product->price }}〒</b> <del></del></span>
                    @if (is_array($items) AND isset($items['products_id'][$product->id]))
                      <a href="/basket" class="btn btn-dark btn-compact" data-toggle="tooltip" data-placement="top" title="Перейти в корзину"><i class="icon icon-bag h5"></i></a>
                    @else
                      <button class="btn btn-primary btn-outline-cart- btn-compact btn-sm" data-basket-id="{{ $product->id }}" onclick="addToBasket(this);" title="Добавить в корзину"><span class="icon icon-cart h5"></span></button>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endforeach
      </div>
    </section>
  @endforeach
