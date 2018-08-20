
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
