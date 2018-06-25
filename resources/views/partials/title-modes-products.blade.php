
  <!-- MODES PRODUCTS -->
  @foreach($modes as $k => $mode)
    <section class="modes-products">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <h2>{{ $mode->title }}</h2><br>
            <div class="xs-tab-slider-6-col owl-carousel tab-slider-center">
              @foreach($mode->products->take(16) as $product)
                <div class="xs-product-category">
                  @foreach($product->modes as $mode)
                    @if(in_array($mode->slug, ['novelty', 'best-price', 'stock']))
                      <div class="offer">
                        <div class="offer-{{ $mode->slug }}">{{ $mode->title }}</div>
                      </div>
                    @endif
                  @endforeach
                  <a href="/goods/{{ $product->id.'-'.$product->slug }}">
                    <img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->title }}">
                  </a>
                  <h4 class="product-title"><a href="/goods/{{ $product->id.'-'.$product->slug }}">{{ $product->title }}</a></h4>
                  <span class="price"><b>{{ $product->price }}〒</b></span>
                  @if (is_array($items) AND isset($items['products_id'][$product->id]))
                    <a href="/basket" class="btn btn-dark btn-compact" data-toggle="tooltip" data-placement="top" title="Перейти в корзину"><i class="icon icon-bag h5"></i></a>
                  @else
                    <button class="btn btn-primary btn-outline-cart- btn-compact btn-sm" data-basket-id="{{ $product->id }}" onclick="addToBasket(this);" title="Добавить в корзину"><span class="icon icon-cart h5"></span></button>
                  @endif
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>
  @endforeach
