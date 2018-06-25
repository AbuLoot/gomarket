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

            <!-- <h4>Фильтр</h4> -->
            <form action="/catalog/{{ $category->slug }}" method="get" id="filter">
              {{ csrf_field() }}
              <!-- <div class="widget widget_range">
                <div class="price_label media">
                  <label for="amount">Фильтр:</label>
                </div>
                <div class="form-row">
                  <div class="col-md-6">
                    <div class="form-group input-price {{ $errors->has('from') ? 'has-error' : '' }}">
                      <input type="text" class="form-control " name="price_from" id="price-from" placeholder="От" minlength="2" maxlength="40" value="{{ '' }}" required>
                      @if ($errors->has('from'))
                        <span class="help-block">{{ $errors->first('from') }}</span>
                      @endif
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group input-price {{ $errors->has('to') ? 'has-error' : '' }}">
                      <input type="text" class="form-control " name="price_to" id="price-to" placeholder="До" minlength="5" maxlength="80" value="{{ '' }}" required>
                      @if ($errors->has('to'))
                        <span class="help-block">{{ $errors->first('to') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn btn-outline-primary btn-compact" id="filter-btn">Поиск</button>
              </div> -->
              <h4>Фильтр</h4><br>

              @foreach ($grouped as $data => $group)
                <div class="widget widget_cate">
                  <h5 class="widget-title">{{ $data }}</h5>
                  @foreach ($group as $option)
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" id="o{{ $option->id }}" name="options_id[]" value="{{ $option->id }}">
                      <label class="custom-control-label" for="o{{ $option->id }}">{{ $option->title }}</label>
                    </div>
                  @endforeach
                </div>
              @endforeach
            </form>

            <!-- <div class="widget widget_cate">
              <h5 class="widget-title">Диагональ экрана</h5>
              <form action="#" method="POST" class="shop_cate_form">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="tenInch">
                  <label class="custom-control-label" for="tenInch">10"<span>(68)</span></label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="nineSeven">
                  <label class="custom-control-label" for="nineSeven">9.7"<span>(5)</span></label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="tenOneInch">
                  <label class="custom-control-label" for="tenOneInch">10.1"<span>(7)</span></label>
                </div>
              </form>
            </div>
            <div class="widget widget_cate">
              <h5 class="widget-title">Операционная система</h5>
              <form action="#" method="POST" class="shop_cate_form">
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="android_7">
                  <label class="custom-control-label" for="android_7">Android 7.0 <span>(2)</span></label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="android_6">
                  <label class="custom-control-label" for="android_6">Android 6.0<span>(50)</span></label>
                </div>
                <div class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input" id="android_5">
                  <label class="custom-control-label" for="android_5">Android 5.0<span>(70)</span></label>
                </div>
              </form>
            </div>
            <div class="widget widget_cate">
              <h5 class="widget-title">Объем данных</h5>
              <form action="#" method="POST" class="shop_cate_form">
                <div class="custom-control custom-radio">
                  <input type="radio" id="sixty-four" name="customRadio" class="custom-control-input">
                  <label class="custom-control-label" for="sixty-four">64<span>(15)</span></label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="thirty-two" name="customRadio" class="custom-control-input">
                  <label class="custom-control-label" for="thirty-two">32<span>(20)</span></label>
                </div>
                <div class="custom-control custom-radio">
                  <input type="radio" id="sixteen" name="customRadio" class="custom-control-input">
                  <label class="custom-control-label" for="sixteen">16<span>(18)</span></label>
                </div>
              </form>
            </div> -->
            <!-- <div class="widget widget_banner">
              <img src="assets/images/image_loader.gif" data-echo="assets/images/web_banner/shop_offer_banner.png" alt="">
            </div> -->
          </aside>
        </section>

        <?php $items = session('items'); ?>
        <section class="col-md-9 col-lg-9" id="products">
          <div class="row category-v4">
            @foreach ($products as $product)
              <div class="col-md-4 col-sm-4 col-xs-6">
                <div class="xs-product-wraper">
                  <a href="/goods/{{ $product->id.'-'.$product->slug }}">
                    <img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->category->title }}">
                  </a>
                  <div class="xs-product-content"><br>
                    <h4 class="product-title"><a href="/goods/{{ $product->id.'-'.$product->slug }}">{{ $product->title }}</a></h4>
                    <span class="price version-2">{{ $product->price }}〒</span>
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
            $('*[data-favorite-id="'+productId+'"]').replaceWith('<button type="button" class="btn btn-like btn-default" data-favorite-id="'+data.id+'" onclick="toggleFavorite(this);"><span class="glyphicon glyphicon-heart '+data.cssClass+'"></span></button>');
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
      var page = $(location).attr('href').split('catalog')[1];

      $('input[name="options_id[]"]:checked').each(function() {
        optionsId.push($(this).val());
      });

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

    // Filter products
    $('#filter-bt1  ').click(function() {

      var priceFrom = $('#price-from').val();
      var priceTo = $('#price-to').val();
      var optionsId = new Array();
      var page = $(location).attr('href').split('catalog')[1];

      $('input[name="options_id[]"]:checked').each(function() {
        optionsId.push($(this).val());
      });

      if (priceFrom > 0) {

        $.ajax({
          type: "get",
          url: '/catalog' + page,
          dataType: "json",
          data: {
            "price_from": priceFrom,
            "price_to": priceTo,
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
