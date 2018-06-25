@extends('layout')

@section('title_description', $product->title_description)

@section('meta_description', $product->meta_description)

@section('content')

  <!--BREADCRUMB-->
  <div class="xs-breadcumb">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item"><a href="/catalog/{{ $product->category->slug }}">{{ $product->category->title }}</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $product->title }}</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- PRODUCT INFO SECTION -->
  <div class="xs-section-padding xs-product-details-section">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="xs-sync-slider-preview">
            <div class="sync-slider-preview owl-carousel">
            @if ($product->images != '')
              <?php $c = 0; ?>
              <?php $images = unserialize($product->images); ?>
              @foreach ($images as $k => $image)
                <div class="item">
                  <img src="/img/products/{{ $product->path.'/'.$images[$k]['image'] }}" alt="{{ $product->title }}">
                </div>
              @endforeach
            @else
              <div class="item">
                <img src="assets/images/big_img/headphone.png" alt="Product">
              </div>
            @endif
            </div>
          </div>
          <div class="sync-slider-thumb owl-carousel">
            @if ($product->images != '')
              <?php $c = 0; ?>
              @foreach ($images as $k => $image)
                <div class="item">
                  <img src="/img/products/{{ $product->path.'/'.$images[$k]['mini_image'] }}" alt="">
                </div>
              @endforeach
            @else
              <div class="item">
                <img src="assets/images/160x96/product_1_160x96.jpg" alt="">
              </div>
            @endif
          </div>
        </div>
        <div class="col-lg-6">
          <div class="summary-content single-product-summary">
            <h3 class="entry-title">{{ $product->category->title }}</h3>
            <h4 class="product-title">{{ $product->title }}</h4>

            {!! $product->characteristic !!}
            <span class="price highlight">
              <del></del>
              {{ $product->price }}〒
            </span>
            <div class="xs-add-to-chart-form row">
              <div class="col-md-8">
                <form action="#">
                  <div class="w-quantity quantity xs_input_number">
                    <input type="number" min="1" max="100" value="1" />
                  </div>
                  <div class="w-quantity-btn">
                    <?php $items = session('items'); ?>
                    @if (is_array($items) AND isset($items['products_id'][$product->id]))
                      <a href="/basket" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Перейти в корзину"><i class="icon icon-bag h6"></i> Оформить</a>
                    @else
                      <button class="btn btn-primary btn-outline-cart- btn-sm" data-basket-id="{{ $product->id }}" onclick="addToBasket(this);" title="Добавить в корзину"><span class="icon icon-cart h6"></span> Добавить</button>
                    @endif
                  </div>
                  <div class="clearfix"></div>
                </form>
              </div>
              <div class="col-md-2">
                <a href="#" class="xs-wishlist-and-compare"><i class="fa fa-heart" aria-hidden="true"></i></a>
              </div>
              <div class="col-md-2">
                <a href="#" class="xs-wishlist-and-compare"><i class="icon icon-shuffle-arrow" aria-hidden="true"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- PRODUCT DETAILS SECTION -->
  <div class="xs-section-padding-bottom">
    <div class="container">
      <ul class="nav nav-tabs xs-nav-tab version-4" id="myTab" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Описание</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="characteristic-tab" data-toggle="tab" href="#characteristic" role="tab" aria-controls="characteristic" aria-selected="false">Характеристика</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Отзывы <span>(0)</span></a>
        </li>
      </ul>
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane animated slideInUp show active" id="description" role="tabpanel" aria-labelledby="description-tab">
          {!! $product->description !!}
        </div>
        <div class="tab-pane animated slideInUp" id="characteristic" role="tabpanel" aria-labelledby="characteristic-tab">
          {!! $product->characteristic !!}
        </div>
        <div class="tab-pane animated slideInUp" id="contact" role="tabpanel" aria-labelledby="contact-tab">
          <div class="row">
            <div class="col-lg-10 mx-auto">
              <div class="row">
                <div class="col-md-6">
                  <div class="rate-detail">
                    <ul class="rate-list">
                      <li>
                        <span class="rate-title">5 Stars</span>
                        <span class="rate-graph">
                          <span class="rate-graph-bar" data-percent="80"></span>
                        </span>
                        <span class="star-rating" data-value="5"></span>
                      </li>
                      <li>
                        <span class="rate-title">4 Stars</span>
                        <span class="rate-graph">
                          <span class="rate-graph-bar" data-percent="60"></span>
                        </span>
                        <span class="star-rating" data-value="4"></span>
                      </li>
                      <li>
                        <span class="rate-title">3 Stars</span>
                        <span class="rate-graph">
                          <span class="rate-graph-bar" data-percent="40"></span>
                        </span>
                        <span class="star-rating" data-value="3"></span>
                      </li>
                      <li>
                        <span class="rate-title">2 Stars</span>
                        <span class="rate-graph">
                          <span class="rate-graph-bar" data-percent="20"></span>
                        </span>
                        <span class="star-rating" data-value="2"></span>
                      </li>
                      <li>
                        <span class="rate-title">1 Stars</span>
                        <span class="rate-graph">
                          <span class="rate-graph-bar" data-percent="10"></span>
                        </span>
                        <span class="star-rating" data-value="1"></span>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="col-md-6 align-self-center">
                  <div class="rate-score clearfix">
                    <span class="star-rating"></span>
                    <p class="rating-score-des">Average Star Rating:  
                      <em>4.7 out of 5</em>
                      (15 votes)
                    </p>
                    <span class="help-tip">
                      <span class="help-tip-text">If you finish the payment today, your order will arrive within the estimated delivery time.</span>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- PRODUCT INFO SECTION -->
  <section class="xs-section-padding bg-gray">
    <div class="container">
      <div class="xs-content-header version-2">
        <h2 class="xs-content-title">Похожие товары</h2>
        <div class="clearfix"></div>
      </div>
      <div class="row">
        @foreach($recent_products as $product)
          <div class="col-md-6 col-lg-3">
            <div class="xs-product-wraper version-2">
              <a href="/goods/{{ $product->id.'-'.$product->slug }}">
                <img src="/img/products/{{ $product->path.'/'.$product->image }}" alt="{{ $product->title }}">
              </a>
              <div class="xs-product-content text-center">
                <span class="product-categories">
                  <a href="/catalog/{{ $product->category->slug }}" rel="tag">{{ $product->category->title }}</a>
                </span>
                <h4 class="product-title"><a href="/goods/{{ $product->id.'-'.$product->slug }}">{{ $product->title }}</a></h4>
                <span class="price">
                  {{ $product->price }}〒
                  <del>{{ $product->price * 1.1 }}〒</del>
                </span>
              </div>
              <div class="xs-product-hover-area clearfix">
                <div class="float-left">
                  <a href="#"><i class="icon icon-online-shopping-cart"></i> В корзину</a>
                </div>
                <div class="float-right">
                  <a href="#"><i class="icon icon-shuffle-arrow"></i>Сравнить</a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>

@endsection

@section('head')
  <link rel="stylesheet" href="/bower_components/photoswipe/dist/photoswipe.css">
  <!-- Skin CSS file (styling of UI - buttons, caption, etc.)
       In the folder of skin CSS file there are also:
       - .png and .svg icons sprite, 
       - preloader.gif (for browsers that do not support CSS animations) -->
  <link rel="stylesheet" href="/bower_components/photoswipe/dist/default-skin/default-skin.css">
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
            $('*[data-basket-id="'+productId+'"]').replaceWith('<a href="/basket" class="btn btn-dark" data-toggle="tooltip" data-placement="top" title="Перейти в корзину"><i class="icon icon-bag h6"></i> Оформить</a>');
            $('#count-items').text(data.countItems);

            var newItem =
              '<li class="mini_cart_item media">' +
                '<a class="d-flex mini-product-thumb" href="/goods/' + productId + '-' + data.slug + '"><img src="/img/products/' + data.img_path + '"></a>' +
                '<div class="media-body">' +
                  '<h4 class="mini-cart-title"><a href="/goods/' + productId + '-' + data.slug + '">' + data.title + '</a></h4>' +
                  '<span class="quantity"><span class="amount">' + data.price + '〒</span></span>' +
                '</div>' +
                '<button class="btn-cancel pull-right">x</button>' +
              '</li>';

            $('#last-li').before(newItem);

            if (data.countItems == 1) {
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

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    })
  </script>
  <script src="/bower_components/photoswipe/dist/photoswipe.min.js"></script>
  <script src="/bower_components/photoswipe/dist/photoswipe-ui-default.min.js"></script>
  <script>
    var initPhotoSwipeFromDOM = function(gallerySelector) {

        // parse slide data (url, title, size ...) from DOM elements 
        // (children of gallerySelector)
        var parseThumbnailElements = function(el) {
            var thumbElements = el.childNodes,
                numNodes = thumbElements.length,
                items = [],
                figureEl,
                linkEl,
                size,
                item;

            for(var i = 0; i < numNodes; i++) {

                figureEl = thumbElements[i]; // <figure> element

                // include only element nodes 
                if(figureEl.nodeType !== 1) {
                    continue;
                }

                linkEl = figureEl.children[0]; // <a> element

                size = linkEl.getAttribute('data-size').split('x');

                // create slide object
                item = {
                    src: linkEl.getAttribute('href'),
                    w: parseInt(size[0], 10),
                    h: parseInt(size[1], 10)
                };


                if(figureEl.children.length > 1) {
                    // <figcaption> content
                    item.title = figureEl.children[1].innerHTML; 
                }

                if(linkEl.children.length > 0) {
                    // <img> thumbnail element, retrieving thumbnail url
                    item.msrc = linkEl.children[0].getAttribute('src');
                } 

                item.el = figureEl; // save link to element for getThumbBoundsFn
                items.push(item);
            }

            return items;
        };

        // find nearest parent element
        var closest = function closest(el, fn) {
            return el && ( fn(el) ? el : closest(el.parentNode, fn) );
        };

        // triggers when user clicks on thumbnail
        var onThumbnailsClick = function(e) {
            e = e || window.event;
            e.preventDefault ? e.preventDefault() : e.returnValue = false;

            var eTarget = e.target || e.srcElement;

            // find root element of slide
            var clickedListItem = closest(eTarget, function(el) {
                return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
            });

            if(!clickedListItem) {
                return;
            }

            // find index of clicked item by looping through all child nodes
            // alternatively, you may define index via data- attribute
            var clickedGallery = clickedListItem.parentNode,
                childNodes = clickedListItem.parentNode.childNodes,
                numChildNodes = childNodes.length,
                nodeIndex = 0,
                index;

            for (var i = 0; i < numChildNodes; i++) {
                if(childNodes[i].nodeType !== 1) { 
                    continue; 
                }

                if(childNodes[i] === clickedListItem) {
                    index = nodeIndex;
                    break;
                }
                nodeIndex++;
            }



            if(index >= 0) {
                // open PhotoSwipe if valid index found
                openPhotoSwipe( index, clickedGallery );
            }
            return false;
        };

        // parse picture index and gallery index from URL (#&pid=1&gid=2)
        var photoswipeParseHash = function() {
            var hash = window.location.hash.substring(1),
            params = {};

            if(hash.length < 5) {
                return params;
            }

            var vars = hash.split('&');
            for (var i = 0; i < vars.length; i++) {
                if(!vars[i]) {
                    continue;
                }
                var pair = vars[i].split('=');  
                if(pair.length < 2) {
                    continue;
                }           
                params[pair[0]] = pair[1];
            }

            if(params.gid) {
                params.gid = parseInt(params.gid, 10);
            }

            return params;
        };

        var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
            var pswpElement = document.querySelectorAll('.pswp')[0],
                gallery,
                options,
                items;

            items = parseThumbnailElements(galleryElement);

            // define options (if needed)
            options = {

                // define gallery index (for URL)
                galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                getThumbBoundsFn: function(index) {
                    // See Options -> getThumbBoundsFn section of documentation for more info
                    var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                        pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                        rect = thumbnail.getBoundingClientRect(); 

                    return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                }

            };

            // PhotoSwipe opened from URL
            if(fromURL) {
                if(options.galleryPIDs) {
                    // parse real index when custom PIDs are used 
                    // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                    for(var j = 0; j < items.length; j++) {
                        if(items[j].pid == index) {
                            options.index = j;
                            break;
                        }
                    }
                } else {
                    // in URL indexes start from 1
                    options.index = parseInt(index, 10) - 1;
                }
            } else {
                options.index = parseInt(index, 10);
            }

            // exit if index not found
            if( isNaN(options.index) ) {
                return;
            }

            if(disableAnimation) {
                options.showAnimationDuration = 0;
            }

            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll( gallerySelector );

        for(var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute('data-pswp-uid', i+1);
            galleryElements[i].onclick = onThumbnailsClick;
        }

        // Parse URL and open gallery if it contains #&pid=3&gid=1
        var hashData = photoswipeParseHash();
        if(hashData.pid && hashData.gid) {
            openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
        }
    };

    // execute above function
    initPhotoSwipeFromDOM('.my-gallery');
  </script>
@endsection
