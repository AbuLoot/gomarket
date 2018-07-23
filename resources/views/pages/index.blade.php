@extends('layout')

@section('title_description', 'Интернет-магазин GoMarket - продажа мобильных телефонов, смартфонов, аксессуаров, планшетов, гаджетов и запчасти для телефонов.')

@section('meta_description', 'Мы предлагаем широкий ассортимент качественной техники')

@section('content')

  <?php $items = session('items'); ?>
  <?php $favorites = session('favorites'); ?>

  <!-- BANNER -->
  <section class="xs-banner">
    <div class="xs-banner-slider owl-carousel">
      @foreach($slide_items as $slide_item)
        <div class="xs-banner-item" style="color: {{ $slide_item->color }}; max-height: 600px; background-image:url('/img/slide/{{ $slide_item->image }}'); background-repeat: no-repeat; background-position: center center;">
          <div class="container">
            <div class="row-">
              <div class="col-lg-7 float-{{ $slide_item->direction }}">
                <div class="xs-banner-content content-{{ $slide_item->direction }} text-{{ $slide_item->direction }}">
                  <h2 class="xs-banner-sub-title animInLeft" style="color: {{ $slide_item->color }};">{{ $slide_item->title }}</h2>
                  <h3 class="xs-banner-title animInLeft">{{ $slide_item->marketing }}</h3>
                  <div class="xs-btn-wraper-">
                    <a href="/{{ $slide_item->link }}" class="btn btn-primary btn-outline-cart- btn-sm text-uppercase">Подробнее</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </section>

  <!-- FEATURE LIST -->
  <section class="xs-featureList-section">
    <div class="container">
      <ul class="xs-feature-list">
        <li>
          <div class="media xs-feature">
            <i class="icon icon-cart d-flex mr-3 align-self-center"></i>
            <!-- <i class="material-icons">shopping_cart</i> -->
            <div class="media-body xs-feature-text">
              <!-- <h4>Бесплатная доставка<br> от 30 000тг по Алмате</h4> -->
              <h4>Быстрая доставка</h4>
            </div>
          </div>
        </li>
        <li>
          <div class="media xs-feature">
            <i class="icon icon-thumbs-up d-flex mr-3 align-self-center"></i>
            <!-- <i class="material-icons">shopping_cart</i> -->
            <div class="media-body xs-feature-text">
              <!-- <h4>6 месяцев гарантии для аксессуаров</h4> -->
              <h4>Гарантия качества</h4>
            </div>
          </div>
        </li>
        <li>
          <div class="media xs-feature">
            <i class="icon icon-deal d-flex mr-3 align-self-center"></i>
            <!-- <i class="material-icons">shopping_cart</i> -->
            <div class="media-body xs-feature-text">
              <!-- <h4>12 месяцев гарантии для смартфонов</h4> -->
              <h4>Оплата наличными при получении товара</h4>
            </div>
          </div>
        </li>
        <li>
          <div class="media xs-feature">
            <i class="icon icon-savings d-flex mr-3 align-self-center"></i>
            <!-- <i class="material-icons">shopping_cart</i> -->
            <div class="media-body xs-feature-text">
              <!-- <h4>24/7</h4> -->
              <h4>Лучшие цены</h4>
              <!-- <span>Онлайн поддержка</span> -->
            </div>
          </div>
        </li>
      </ul>
    </div>
  </section><br><br><br>

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
                  <div class="offer">
                    @foreach($product->modes as $m)
                      @if(in_array($m->slug, ['novelty', 'best-price', 'stock', 'plus-gift']))
                        <div class="offer-{{ $m->slug }}">{{ $m->title }}</div>
                      @endif
                    @endforeach
                  </div>
                  <div class="xs-product-content">
                    <h4 class="product-title"><a href="/goods/{{ $product->id.'-'.$product->slug }}">{{ $product->title }}</a></h4>
                    <span class="price"><b>{{ $product->price }}〒</b> <del></del></span>

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
        @endforeach
      </div>
    </section>
  @endforeach


  <!-- GOMARKET TRENDS -->
  <section class="xs-deal-of-the-day-section bg-semi-black bg-semi-black">
    <div class="xs-slider-highlight owl-carousel">
      @foreach($trend_mode->products->take(5) as $trend_product)
        <div class="container">
          <div class="row">
            <?php $images = unserialize($trend_product->images); ?>
            <div class="col-md-6 align-self-center xs-deal-img animInLeft">
              <img style="max-height: 450px" src="/img/products/{{ $trend_product->path.'/'.$images[0]['image'] }}" alt="">
            </div>
            <div class="col-md-6 align-self-center">
              <div class="xs-best-deal-slider-content">
                <h2 class="best-deal-sub-title animInRight">{{ $trend_product->category->title }}</h2>
                <h3 class="best-deal-title animInRight">{{ $trend_product->title }}</h3>
                <span class="price animInRight">
                  <b>{{ $trend_product->price }}〒</b>
                  <del>{{ $trend_product->price * 1.1 }}〒</del>
                </span>
                <div class="xs-btn-wraper">
                  <a href="/goods/{{ $trend_product->id.'-'.$trend_product->slug }}" class="btn btn-success animInRight">ПОСМОТРЕТЬ</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <span class="xs-watermark-text">GoMarket Trends</span>
  </section>

  <!-- PRODUCTS LIST 2 -->
  <section class="xs-section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="xs-content-header content-header-v2">
            <ul class="nav nav-tabs xs-nav-tab version-3" role="tablist">
              @foreach($categories_part as $k => $category_item)
                <li class="nav-item">
                  <a class="nav-link @if($k == '0') active @endif" id="{{ $category_item->slug }}-tab" data-toggle="tab" href="#today-{{ $category_item->slug }}" role="tab" aria-controls="today-{{ $category_item->slug }}" aria-selected="true">{{ $category_item->title }}</a>
                  <div class="customNavigation xs-custom-nav">
                    <a class="prev" href="#{{ $category_item->slug }}Carousel" role="button" data-slide="prev"><i class="icon icon-left-arrows"></i></a>
                    <a class="next" href="#{{ $category_item->slug }}Carousel" role="button" data-slide="next"><i class="icon icon-right-arrow"></i></a>
                  </div>
                </li>
              @endforeach
            </ul>
            <div class="clearfix"></div>
          </div>

          <!-- TAB CONTENT -->
          <div class="tab-content">
            @foreach($categories_part as $k => $category_item)
              <div class="tab-pane fade show @if($k == '0') active @endif" id="today-{{ $category_item->slug }}" role="tabpanel" aria-labelledby="{{ $category_item->slug }}-tab">
                <div class="carousel slide" id="{{ $category_item->slug }}Carousel" data-ride="carousel" data-interval="false">
                  <div class="carousel-inner">
                    <?php $products_item = $group_products[$k]; ?>
                    @foreach($products_item->take(16)->chunk(8) as $key => $chunk)
                      <div class="carousel-item @if($key == '0') active @endif">
                        <div class="row">
                          @foreach($chunk as $product)
                            <div class="col-lg-3 col-md-6 col-xs-6">
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
                                  <span class="product-categories">
                                    <a href="/catalog/{{ $category_item->slug }}" rel="tag">{{ $category_item->title }}</a>
                                  </span>
                                  <h4 class="product-title"><a href="/goods/{{ $product->id.'-'.$product->slug }}">{{ $product->title }}</a></h4>
                                  <span class="price"><b>{{ $product->price }}〒</b> <del></del></span>

                                  @if (is_array($favorites) AND in_array($product->id, $favorites['products_id']))
                                    <button type="button" class="btn btn-dark btn-compact m-10 btn-sm" data-favorite-id="{{ $product->id }}" onclick="toggleFavorite(this);" title="Добавлено в избранные"><span class="icon icon-heart h5"></span></button>
                                  @else
                                    <button type="button" class="btn btn-outline-primary btn-compact m-10 btn-sm" data-favorite-id="{{ $product->id }}" onclick="toggleFavorite(this);" title="Добавить в избранные"><span class="icon icon-heart h5"></span></button>
                                  @endif

                                  @if (is_array($items) AND in_array($product->id, $items['products_id']))
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
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- VIEWED PRODUCTS -->
  <!-- <section class="xs-section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="xs-content-header">
            <h2 class="xs-content-title">Hot New Arrivals</h2>
            <div class="clearfix"></div>
          </div>

          <div class="xs-tab-slider-6-col owl-carousel">
            foreach($products_viewed as $product_viewed)
              <div class="xs-product-category text-center">
                <img src="/img/products/ $product->path.'/'.$product->image }}" alt=" $product->category->title }}">
                <h4 class="product-title"><a href="/goods/ $product->id.'-'.$product->slug }}"> $product->title }}</a></h4>
                <span class="price"> $product->price }}〒</span>
              </div>
            endforeach
          </div>
        </div>
      </div>
    </div>
  </section> -->

  <!-- BRAND LIST -->
  <section class="xs-brand-section">
    <div class="container">
      <div class="row">
        <div class="offset-md-1 col-md-2"><a href="#"><img class="mx-auto d-block" src="/img/brands/apple.png" alt="Partners"></a><br></div>
        <div class="col-md-2"><a href="#"><img class="mx-auto d-block" src="/img/brands/xiaomi.png" alt="Partners"></a><br></div>
        <div class="col-md-2"><a href="#"><img class="mx-auto d-block" src="/img/brands/samsung.png" alt="Partners"></a><br></div>
        <div class="col-md-2"><a href="#"><img class="mx-auto d-block" src="/img/brands/huawei.png" alt="Partners"></a><br></div>
        <div class="col-md-2"><a href="#"><img class="mx-auto d-block" style="margin-top: 25px;" src="/img/brands/meizu.png" alt="Partners"></a><br></div>
      </div>
    </div>
  </section>

@endsection

@section('scripts')
  <script>
    function addToBasket(i) {
      var productId = $(i).data("basket-id");

      if (productId != '') {
        $.ajax({
          type: "get",
          url: '/add-to-basket/'+productId,
          dataType: "json",
          data: {},
          success: function(data) {
            $('*[data-basket-id="'+productId+'"]').replaceWith('<a href="/basket" class="btn btn-dark btn-compact" data-toggle="tooltip" data-placement="top" title="Перейти в корзину"><i class="icon icon-bag h5"></i></a>');
            $('#count-items').text(data.countItems);

            var newItem =
              '<li class="mini_cart_item media" id="cart-goods-id-' + productId + '">' +
                '<a class="d-flex mini-product-thumb" href="/goods/' + productId + '-' + data.slug + '"><img src="/img/products/' + data.img_path + '"></a>' +
                '<div class="media-body">' +
                  '<h4 class="mini-cart-title"><a href="/goods/' + productId + '-' + data.slug + '">' + data.title + '</a></h4>' +
                  '<span class="quantity"><span class="amount">' + data.price + '〒</span></span>' +
                '</div>' +
                '<button data-remove-goods-id="' + productId + '" onclick="removeFromBasket(this);" class="btn-cancel pull-right">x</button>' +
              '</li>';

            $('#last-li').before(newItem);

            if (data.countItems = 1) {
              var toBasket = 
                '<div class="mini-cart-btn">' +
                  '<a class="badge badge-pill badge-primary" href="/basket">Перейти к оплате</a>' +
                '</div>';

              $('#last-li').html(toBasket);
            }

            alert('Товар добавлен в корзину');
          }
        });
      } else {
        alert("Ошибка сервера");
      }
    }

    function toggleFavorite (f) {
      var productId = $(f).data("favorite-id");

      if (productId != '') {
        $.ajax({
          type: "get",
          url: '/toggle-favorite/'+productId,
          dataType: "json",
          data: {},
          success: function(data) {
            $('*[data-favorite-id="'+productId+'"]').replaceWith('<button type="button" class="btn '+data.cssClass+' btn-compact m-10 btn-sm" data-favorite-id="'+data.id+'" onclick="toggleFavorite(this);" title="Добавлено в избранные"><span class="icon icon-heart h5"></span></button>');
            $('#count-favorites').text(data.countFavorites);
          }
        });
      } else {
        alert("Ошибка сервера");
      }
    }
  </script>
@endsection
