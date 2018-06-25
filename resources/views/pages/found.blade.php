@extends('layout')

@section('content')

  <!--BREADCRUMB-->
  <div class="xs-breadcumb">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active" aria-current="page">Поиск</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- SHOP SECTION -->
  <section class="xs-section-padding">
    <div class="container">
      <h2>Поиск по запросу <b>"{{ $text }}"</b></h2>
      <div class="row">
        <div class="col-md-9 col-lg-9">
          <div class="row category-v4">
            @foreach ($products as $product)
              <div class="col-md-4 col-sm-4 col-xs-6">
                <div class="xs-product-wraper">
                  <img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->category->title }}">
                  <div class="xs-product-content"><br>
                    <h4 class="product-title"><a href="/goods/{{ $product->id.'-'.$product->slug }}">{{ $product->title }}</a></h4>
                    <span class="price version-2">
                      {{ $product->price }}〒
                      <del></del>
                    </span>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          <!-- Pagination -->
          {{ $products->links('vendor.pagination.bootstrap-4') }}

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
            $('*[data-basket-id="'+productId+'"]').replaceWith('<a href="/basket" class="btn btn-basket btn-success" data-toggle="tooltip" data-placement="top" title="Перейти в корзину"><span class="glyphicon glyphicon-shopping-cart"></span> Оформить</a>');
            $('#count-items').text(data.countItems);
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
@endsection
