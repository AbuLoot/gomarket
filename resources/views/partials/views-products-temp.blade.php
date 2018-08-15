
  <!-- VIEWED PRODUCTS -->
  <section class="xs-section-padding">
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
  </section>
