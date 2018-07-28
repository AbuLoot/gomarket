
  <?php $items = session('items'); ?>
  <?php $favorites = session('favorites'); ?>

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
