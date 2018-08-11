@extends('layout')

@section('title_description', $category->title_description)

@section('meta_description', $category->meta_description)

@section('content')

  <!-- BREADCRUMB -->
  <div class="xs-breadcumb">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $category->title }}</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- SHOP SECTION -->
  <section class="xs-section-padding">
    <div class="container">
      <div class="row">
        <section class="col-md-3 col-lg-3">
          <!-- SIDEBAR -->
          <aside class="shop-category">
            <?php
              if (isset($_SERVER['QUERY_STRING'])) {
                $options_query = explode('&', $_SERVER['QUERY_STRING']);
                $options_id = [];
                foreach ($options_query as $option_query) {
                  list($params, $options_id[]) = explode('=', $option_query);
                }
              }
            ?>
            <form action="/catalog/{{ $category->slug }}" method="get" id="filter">
              {{ csrf_field() }}
              <h4>Фильтр</h4><br>

              @foreach ($grouped as $data => $group)
                <div class="widget widget_cate">
                  <h5 class="widget-title">{{ $data }}</h5>
                  @foreach ($group as $option)
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="o{{ $option->id }}" name="options_id[]" value="{{ $option->id }}" @if(isset($options_id) AND in_array($option->id, $options_id)) checked @endif>
                      <label class="custom-control-label" for="o{{ $option->id }}">{{ $option->title }}</label>
                    </div>
                  @endforeach
                </div>
              @endforeach
            </form>
          </aside>
        </section>

        <?php $items = session('items'); ?>
        <?php $favorites = session('favorites'); ?>

        <section class="col-md-9 col-lg-9" id="products">
          <div class="row category-v4">
            @foreach ($products as $product)
              <div class="col-md-4 col-sm-4 col-xs-6">
                <div class="xs-product-wraper">
                  <a href="/goods/{{ $product->id.'-'.$product->slug }}">
                    <img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->category->title }}">
                  </a>
                  <div class="offer">
                    @foreach($product->modes as $m)
                      @if(in_array($m->slug, ['novelty', 'best-price', 'stock', 'plus-gift']))
                        <div class="offer-{{ $m->slug }}">{{ $m->title }}</div>
                      @endif
                    @endforeach
                  </div>
                  <div class="xs-product-content"><br>
                    <h4 class="product-title"><a href="/goods/{{ $product->id.'-'.$product->slug }}">{{ $product->title }}</a></h4>
                    <span class="price version-2">
                      @if($product->status == 1)
                        {{ $product->price }}〒
                      @else
                        {{ trans('statuses.data.'.$product->status) }}
                      @endif
                    </span>

                    @if (is_array($favorites) AND in_array($product->id, $favorites['products_id']))
                      <button type="button" class="btn btn-dark btn-compact m-10 btn-sm" data-favorite-id="{{ $product->id }}" onclick="toggleFavorite(this);" title="Добавлено в избранные"><span class="icon icon-heart h5"></span></button>
                    @else
                      <button type="button" class="btn btn-outline-primary btn-compact m-10 btn-sm" data-favorite-id="{{ $product->id }}" onclick="toggleFavorite(this);" title="Добавить в избранные"><span class="icon icon-heart h5"></span></button>
                    @endif

                    @if (is_array($items) AND isset($items['products_id'][$product->id]))
                      <a href="/basket" class="btn btn-dark btn-compact" data-toggle="tooltip" data-placement="top" title="Перейти в корзину"><i class="icon icon-bag h5"></i></a>
                    @else
                      <button class="btn btn-primary btn-compact btn-sm" data-basket-id="{{ $product->id }}" onclick="addToBasket(this);" title="Добавить в корзину"><span class="icon icon-cart h5"></span></button>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <!-- Pagination -->
          {{ $products->links('vendor.pagination.bootstrap-4') }}

        </section>
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

  <script>
    // Filter products
    $('#filter').on('click', 'input', function(e) {

      var optionsId = new Array();

      $('input[name="options_id[]"]:checked').each(function() {
        optionsId.push($(this).val());
      });

      var page = $(location).attr('href').split('catalog')[1];

      // window.history.pushState('', '', '/'.optionsId);
      console.log($(location).attr('href'));

      if (optionsId.length > 0) {
        $.ajax({
          type: "get",
          url: '/catalog' + page,
          dataType: "json",
          data: {
            "options_id": optionsId
          },
          success: function(data) {
            $('#products').html(data);
          }
        });
      } else {
        $.ajax({
          type: "get",
          url: '/catalog' + page,
          dataType: "json",
          success: function(data) {
            $('#products').html(data);
          }
        });
      }
    });
  </script>
@endsection
