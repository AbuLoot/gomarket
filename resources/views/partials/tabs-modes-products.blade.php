
  <!-- PRODUCTS LIST -->
  <section class="xs-section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="xs-content-header content-header-v2">
            <ul class="nav nav-tabs xs-nav-tab version-3" role="tablist">
              @foreach($modes as $k => $mode)
                <li class="nav-item">
                  <a class="nav-link @if($k == '0') active @endif" id="{{ $mode->slug }}-tab" data-toggle="tab" href="#today-{{ $mode->slug }}" role="tab" aria-controls="today-{{ $mode->slug }}" aria-selected="true">{{ $mode->title }}</a>
                  <div class="customNavigation xs-custom-nav">
                    <a class="prev" href="#{{ $mode->slug }}Carousel" role="button" data-slide="prev"><i class="icon icon-left-arrows"></i></a>
                    <a class="next" href="#{{ $mode->slug }}Carousel" role="button" data-slide="next"><i class="icon icon-right-arrow"></i></a>
                  </div>
                </li>
              @endforeach
            </ul>
            <div class="clearfix"></div>
          </div>

          <!-- TAB CONTENT -->
          <div class="tab-content">
            @foreach($modes as $k => $mode)
              <div class="tab-pane fade show @if($k == '0') active @endif" id="today-{{ $mode->slug }}" role="tabpanel" aria-labelledby="{{ $mode->slug }}-tab">
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
                                @if(in_array($mode->slug, ['new', 'best-price', 'stock']))
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
