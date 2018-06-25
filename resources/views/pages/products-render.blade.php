
  <?php $items = session('items'); ?>

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
