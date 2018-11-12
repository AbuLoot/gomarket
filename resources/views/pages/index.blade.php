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
        <div class="xs-banner-item" style="color:{{ $slide_item->color }}; background-image:url('/img/slide/{{ $slide_item->image }}'); background-repeat:no-repeat;">
          <style type="text/css">
            @media (max-width: 480px) {
              .xs-banner-item { background-position:{{ $slide_item->sort_id  }}% 0; }
            }
          </style>
          <div class="container">
            <div class="row">
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

  <!-- MOBILE CATEGORIES -->
  <div class="accordion d-md-none" id="accordionCategories">
    <div class="card">
      <?php $traverse = function ($categories) use (&$traverse) { ?>
        <?php foreach ($categories as $category) : ?>
          <?php if ($category->isRoot()) : ?>
            <div class="card-header" id="heading{{ $category->id }}">
              <h4 class="mb-0">
                <a class="d-block collapsed" href="/catalog/{{ $category->slug }}" data-toggle="collapse" data-target="#collapse{{ $category->id }}" aria-expanded="true" aria-controls="collapseOne"><i class="material-icons">{{ $category->image }}</i> {{ $category->title }} <span class=""><i class="material-icons expand_more">expand_more</i></span></a>
              </h4>
            </div>
            <div id="collapse{{ $category->id }}" class="collapse" aria-labelledby="heading{{ $category->id }}" data-parent="#accordionCategories">
              <div class="card-body">
                <ul class="list-unstyled">
                  <li><p><a class="d-block" href="/catalog/all/{{ $category->slug }}">{{ $category->title_extra }}</a></p></li>
                  <?php $traverse($category->children); ?>
                </ul>
              </div>
            </div>
          <?php else : ?>
            <li><p><a class="d-block" href="/catalog/{{ $category->slug }}">{{ $category->title }}</a></p></li>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php }; ?>
      <?php $traverse($categories); ?>
    </div>
  </div>

  <!-- FEATURE LIST -->
  <section class="xs-featureList-section">
    <div class="container">
      <ul class="xs-feature-list">
        <li>
          <div class="media xs-feature">
            <i class="icon icon-cart d-flex mr-3 align-self-center"></i>
            <div class="media-body xs-feature-text">
              <h4>Быстрая доставка</h4>
            </div>
          </div>
        </li>
        <li>
          <div class="media xs-feature">
            <i class="icon icon-thumbs-up d-flex mr-3 align-self-center"></i>
            <div class="media-body xs-feature-text">
              <h4>Гарантия качества</h4>
            </div>
          </div>
        </li>
        <li>
          <div class="media xs-feature">
            <i class="icon icon-deal d-flex mr-3 align-self-center"></i>
            <div class="media-body xs-feature-text">
              <h4>Оплата наличными при получении товара</h4>
            </div>
          </div>
        </li>
        <li>
          <div class="media xs-feature">
            <i class="icon icon-savings d-flex mr-3 align-self-center"></i>
            <div class="media-body xs-feature-text">
              <h4>Лучшие цены</h4>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </section><br><br>

  <!-- MODES PRODUCTS -->
  @foreach($modes as $k => $mode)
    <section class="modes-products">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-sm-6 col-xs-6">
            <h2 class="h1">{{ $mode->title }}</h2><br>
          </div>
          <div class="col-lg-6 col-sm-6 col-xs-6">
            <div class="customNavigation xs-custom-nav h2 text-right">
              <a class="prev" style="color: #941781;" href="#{{ $mode->slug }}Carousel" role="button" data-slide="prev"><b><i class="icon icon-left-arrows"></i></b></a>
              <a class="next" style="color: #941781;" href="#{{ $mode->slug }}Carousel" role="button" data-slide="next"><b><i class="icon icon-right-arrow"></i></b></a>
            </div>
          </div>
        </div>
        <div class="carousel slide" id="{{ $mode->slug }}Carousel" data-ride="carousel" data-interval="false">
          <div class="carousel-inner">
            @foreach($mode->products->where('status', 1)->take(16)->chunk(8) as $key => $chunk)
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
                            <a href="/catalog/{{ $mode->slug }}" rel="tag">{{ $mode->title }}</a>
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
    </section>
  @endforeach


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
                  <div class="customNavigation xs-custom-nav h2 text-right">
                    <a class="prev" style="color: #941781;" href="#{{ $category_item->slug }}Carousel" role="button" data-slide="prev"><i class="icon icon-left-arrows"></i></a>
                    <a class="next" style="color: #941781;" href="#{{ $category_item->slug }}Carousel" role="button" data-slide="next"><i class="icon icon-right-arrow"></i></a>
                  </div>
                </li>
              @endforeach
            </ul>
            <div class="clearfix"></div>
          </div>

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

  <!-- NEWS -->
  <section class="xs-section-padding bg-gray">
    <div class="container">
      <div class="xs-content-header version-2">
        <h2 class="xs-content-title">Новости
          <a class="icon-nav-news" href="#carouselNews" role="button" data-slide="prev"><i class="material-icons">arrow_back_ios</i></a>
          <a class="icon-nav-news" href="#carouselNews" role="button" data-slide="next"><i class="material-icons">arrow_forward_ios</i></a>
        </h2>
        <a href="/news" class="xs-simple-btn">Все Новости</a>
        <div class="clearfix"></div>
      </div>
      <div id="carouselNews" class="carousel slide" data-interval="false" data-ride="carousel">
        <div class="carousel-inner">
          @foreach($news->chunk(3) as $key => $chunk)
            <div class="carousel-item @if($key == 0) active @endif">
              <div class="row">
                @foreach($chunk as $newsSingle)
                  <div class="col-sm-4 col-md-6 col-lg-4">
                    <div class="xs-single-news">
                      <div class="entry-thumbnail">
                        @if(strlen($newsSingle->video) < 10)
                          <img src="/img/news/present-{{ $newsSingle->image }}" class="img-responsive" alt="{{ $newsSingle->title }}">
                        @else
                          <div class="thumb-wrap">
                            {!! $newsSingle->video !!}
                          </div>
                        @endif
                      </div>
                      <div class="xs-news-content">
                        <div class="entry-header">
                          <div class="entry-meta">
                            <span class="tags-links">
                              <!-- <a href="#">Electronics</a> -->
                            </span>
                          </div>
                          <h4 class="entry-title"><a href="/news/{{ $newsSingle->slug }}">{{ $newsSingle->title }}</a></h4>
                        </div>
                        <div class="post-meta">
                          <span class="post-meta-date"><i class="fa fa-calendar"></i> {{ $newsSingle->getRusDateAttribute() }}</span>
                        </div>
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

    $(document).ready(function(){
      $(".owl-carousel").owlCarousel();

    });
  </script>
@endsection
