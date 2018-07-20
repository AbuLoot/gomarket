
  <!-- BANNER -->
  <section class="xs-banner">
    <div class="owl-carousel xs-banner-slider" style="max-height: 600px; background-image:url('/img/slider/background_4.jpg'); background-repeat: no-repeat; background-position: center;">
      @foreach($slide_mode->products->where('status', 1)->take(10) as $slide_product)
        <div class="xs-banner-item">
          <div class="container">
            <div class="row">
              <div class="col-lg-7">
                <div class="xs-banner-content content-right">
                  <h2 class="xs-banner-sub-title animInLeft">{{ $slide_product->title }}</h2>
                  <h3 class="xs-banner-title animInLeft">{{ str_limit($slide_product->meta_description, 60) }}</h3>
                  <div class="xs-btn-wraper">
                    <a href="/goods/{{ $slide_product->id.'-'.$slide_product->slug }}" class="btn btn-primary btn-outline-cart- btn-sm text-uppercase">Подробнее</a>
                  </div>
                </div>
              </div>
              <div class="col-lg-5">
                <?php $images = unserialize($slide_product->images); ?>
                <div class="xs-banner-image animInRight">
                  <img src="/img/products/{{ $slide_product->path.'/'.$images[0]['image'] }}" alt="{{ $slide_product->title }}">
                </div>
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </section>
