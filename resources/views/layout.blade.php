<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>@yield('title_description', 'GoMarket.kz')</title>
  <meta name="description" content="@yield('meta_description', 'GoMarket.kz')">

  <link rel="icon" type="image/icon" href="/favicon.ico">
  <link rel="shortcut icon" type="image/x-icon" href="/favicon.png">

  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link rel="icon" type="image/png" href="favicon.ico">
  <link rel="apple-touch-icon" href="apple-touch-icon.png">
  <link rel="stylesheet" href="/assets/css/font-awesome.min.css">
  <link rel="stylesheet" href="/assets/css/jquery-ui.css">

  <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
  <link rel="stylesheet" href="/assets/css/animate.css">
  <link rel="stylesheet" href="/assets/css/iconfont.css">
  <link rel="stylesheet" href="/assets/css/isotope.css">
  <link rel="stylesheet" href="/assets/css/magnific-popup.css">
  <link rel="stylesheet" href="/assets/css/owl.carousel.min.css">
  <link rel="stylesheet" href="/assets/css/owl.theme.default.min.css">
  <link rel="stylesheet" href="/assets/css/vertical-menu.css">
  <link rel="stylesheet" href="/assets/css/navigation.min.css">

  <link href="/bower_components/typeahead.js/dist/typeahead.bootstrap.css" rel="stylesheet">

  <!--For Plugins external css-->
  <link rel="stylesheet" href="/assets/css/plugins.css" />

  <!--Theme custom css -->
  <!-- <link rel="stylesheet" href="/assets/css/style.css"> -->
  <link rel="stylesheet" href="/assets/sass/output.css">

  <!--Theme Responsive css-->
  <link rel="stylesheet" href="/assets/css/responsive.css" />
  <link rel="stylesheet" href="/assets/css/custom.css">
  @yield('head')

</head>
<body>
  <!--[if lt IE 10]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
  <![endif]-->

  <!-- TOP BAR -->
  <div class="top-bar">
    <div class="container">
      <div class="row">
        <div class="col-md-7 col-xs-8">
          <ul class="xs-top-bar-info xs-social-list">
            <li><a href="#"><i class="material-icons">place</i> г. Алматы, ул. Желтоксана 78/86</a></li>
            <li><a href="#"><i class="material-icons">access_time</i> c 10:00 до 20:00 Без выходных!</a></li>
          </ul>
        </div>
        <div class="col-md-5 col-xs-4">
          <ul class="xs-top-bar-info right-content">
            <!-- <li><a href="#" data-toggle="modal" data-target=".xs-modal">Регистрация</a></li> -->
            <!-- <li><a href="#" data-toggle="modal" data-target=".xs-modal">Войти</a></li> -->
            @guest
              <li><a href="/login-or-reg">Войти</a></li>
            @else
              <li>
                <a href="/my-profile"><i class="material-icons">account_circle</i> {{ Auth::user()->name }}</a>
              </li>
            @endguest
          </ul>
        </div>
      </div> 
    </div>
  </div>

  <!-- HEADER -->
  <header class="xs-header">

    <!-- NAVBAR -->
    <div class="xs-navBar secondary-color-v">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-sm-4 xs-order-1">
            <div class="xs-logo-wraper">
              <a href="/">
                <img src="/assets/images/gomarket.png" alt="">
              </a>
            </div>
          </div>
          <div class="col-lg-6 xs-order-2 xs-logo-wraper">
            <form class="xs-navbar-search" method="get" action="/search">
              <div class="input-group">
                <input type="search" name="text" class="typeahead-goods form-control" placeholder="Что вы ищите?" data-provide="typeahead">
                <div class="input-group-btn btn-search">
                  <input type="hidden" id="search-param" name="post_type" value="product">
                  <button type="submit" class="btn btn-primary"><i class="material-icons">search</i></button>
                </div>
              </div>
            </form>
          </div>
          <div class="col-lg-3 xs-logo-wraper">
            <div class="header-phones text-right">
              <!-- <h5 class="xs-phone margin-top-5">[WhatsApp]</h5> -->
              <h5 class="xs-phone"><a href="whatsapp://send?phone=+77005035045" class="color-primary"><strong><span class="w4"><span class="fa fa-whatsapp" ></span></span> +7 (707) 2017555</strong></a></h5>
              <h5 class="xs-phone"><a href="tel:+77072017555" class="color-primary"><strong><i class="material-icons">phone_android</i> +7 (707) 2017555</strong></a></h5>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="xs-navDown navDown-v5 bg-violet secondary-color-v">
      <div class="container">
        <div class="row">
          <!-- ALL CATEGORIES -->
          <div class="col-lg-3 col-xs-8 xs-order-1 d-lg-block">
            <div class="cd-dropdown-wrapper xs-vartical-menu">
              <a class="cd-dropdown-trigger" href="#0">
                <i class="material-icons">apps</i> Каталог <span class="d-xs-none">товаров</span>
              </a>
              <nav class="cd-dropdown">
                <h2>GoMarket</h2>
                <a href="#0" class="cd-close">Close</a>
                <ul class="cd-dropdown-content">
                  <?php $traverse = function ($categories) use (&$traverse) { ?>
                    <?php foreach ($categories as $category) : ?>
                      <?php if ($category->children && count($category->children) > 0) : ?>
                        <li class="has-children">
                          <a  href="#"><i class="material-icons">{{ $category->image }}</i> {{ $category->title }} <i class="fa fa-angle-right d-xs-none submenu-icon"></i></a>
                          <ul class="cd-secondary-dropdown is-hidden">
                            <li class="go-back"><a href="#0">Меню</a></li>
                            <li class="has-children">
                              <a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a>
                              <ul class="is-hidden">
                                <li class="go-back"><a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a></li>
                                <?php $traverse($category->children); ?>
                              </ul>
                            </li>
                          </ul>
                        </li>
                      <?php else : ?>
                        <li><a href="/catalog/{{ $category->slug }}">{{ $category->title }}</a></li>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  <?php }; ?>
                  <?php $traverse($categories); ?>
                </ul>
              </nav>
            </div>
          </div>
          <!-- MENU -->
          <div class="col-lg-7 col-xs-2 xs-order-3 xs-menus-group2">
            <nav class="xs-menus">
              <div class="nav-header">
                <div class="nav-toggle"></div>
              </div>
              <div class="nav-menus-wrapper">
                <ul class="nav-menu">
                  @foreach ($pages as $page)
                    <li><a href="/{{ $page->slug }}">{{ $page->title }}</a></li>
                  @endforeach
                </ul>
              </div>
            </nav>
          </div>
          <!-- COUNTS -->
          <div class="col-lg-2 col-xs-2 xs-order-2 xs-wishlist-group2">
            <div class="xs-wish-list-item">
              <!-- <span class="xs-wish-list">
                <a href="#" class="xs-single-wishList d-none d-md-none d-lg-block">
                  <span class="xs-item-count highlight">0</span>
                  <i class="icon icon-heart"></i>
                </a>
              </span> -->
              <span class="xs-wish-list">
                <a href="compare.html" class="xs-single-wishList d-none d-md-none d-lg-block">
                  <span class="xs-item-count highlight">0</span>
                  <i class="icon icon-arrows"></i>
                </a>
              </span>

              <?php $items = session('items'); ?>
              <div class="dropdown dropright xs-miniCart-dropdown">
                <a href="#" class="dropdown-toggle xs-single-wishList" data-toggle="dropdown" aria-expanded="false">
                  <span class="xs-item-count highlight" id="count-items">{{ (is_array($items)) ? count($items['products_id']) : 0 }}</span>
                  <i class="icon icon-bag"></i>
                </a>
                <ul class="dropdown-menu fadeIns xs-miniCart-menu">
                  @if (isset($items))
                    @foreach ($items['products_id'] as $item)
                      <li class="mini_cart_item media" id="cart-goods-id-{{ $item['id'] }}">
                        <a class="d-flex mini-product-thumb" href="/goods/{{ $item['id'].'-'.$item['slug'] }}"><img src="/img/products/{{ $item['img_path'] }}"></a>
                        <div class="media-body">
                          <h4 class="mini-cart-title"><a href="/goods/{{ $item['id'].'-'.$item['slug'] }}">{{ $item['title'] }}</a></h4>
                          <span class="quantity"><span class="amount">{{ $item['price'] }}〒</span></span>
                        </div>
                        <button data-remove-goods-id="{{ $item['id'] }}" onclick="removeFromBasket(this);" class="btn-cancel pull-right">x</button>
                      </li>
                    @endforeach
                    <li id="last-li">
                      <div class="mini-cart-btn">
                        <a class="badge badge-pill badge-primary" href="/basket">Перейти к оплате</a>
                      </div>
                    </li>
                  @else
                    <li id="last-li">
                      <span>Корзина пуста</span>
                    </li>
                  @endif
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- <div class="nav-cover"></div> -->
  </header>

  @include('layouts.alerts')

  <!-- CONTENT -->
  @yield('content')

  <!-- FOOTER -->
  <footer class="xs-footer-section bg-dark">
    <div class="xs-footer-main">
      <div class="container">
        <div class="row">
          <div class="col-md-4 col-lg-3 footer-widget">
            <h3 class="widget-title">О нас</h3>
            <p>Gomarket.kz – один из ведущих интернет-магазинов мобильной и цифровой техники в Казахстане.</p>
            <p>Интернет-магазин «Go Market» – это удобство оплаты и доставки</p>
          </div>
          <div class="col-md-4 col-lg-3 footer-widget">
            <h3 class="widget-title">Страницы</h3>
            <ul class="xs-list">
              @foreach ($pages as $page)
                @if (Request::is($page->slug, $page->slug.'/*'))
                  <li class="active"><a href="/{{ $page->slug }}">{{ $page->title }}</a></li>
                @else
                  <li><a href="/{{ $page->slug }}">{{ $page->title }}</a></li>
                @endif
              @endforeach
            </ul>
          </div>
          <div class="col-md-4 col-lg-3 footer-widget">
            <h3 class="widget-title">Наши контакты</h3>
              <span>GoMarket, Inc.</span><br>
              <span>ул. Желтоксана 78/86</span><br>
              <span>Алматы, Казахстан </span><br>
              <span>Phone: +7 707 201 75 55</span><br>
              <span>WhatsApp: +7 (707) 201-75-55</span><br>
              <span>Email: info@gomarket.kz</span>
          </div>
        </div>
      </div>
    </div>
    <div class="xs-copyright copyright-gray">
      <div class="container">
        <div class="row">
          <div class="col-md-6">
            <div class="xs-copyright-text">
              Copyright &copy; {{ date('Y') }} GoMarket. Все права защищены.
            </div>
          </div>
          <div class="col-md-6">
            <ul class="xs-social-list version-2">
              <li><a href="#"><i class="fa fa-google-plus"></i>Google+</a></li>
              <li><a href="#"><i class="fa fa-facebook"></i>Facebook</a></li>
              <li><a href="#"><i class="fa fa-twitter"></i>Twitter</a></li>
              <li><a href="#"><i class="fa fa-vk"></i>Вконтакте</a></li>
              <li><a href="#"><i class="fa fa-instagram"></i> Instagram</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- back to top -->
    <div class="xs-back-to-top-wraper">
      <a href="#" class="xs-back-to-top btn btn-success">На вверх<i class="icon icon-arrow-right"></i></a>
    </div>
  </footer>

  <script src="/assets/js/jquery-3.2.1.min.js"></script>
  <script src="/assets/js/jquery-ui.js"></script>
  <script src="/assets/js/modernizr.js"></script>
  <script src="/assets/js/plugins.js"></script>
  <script src="/assets/js/Popper.js"></script>
  <script src="/assets/js/bootstrap.min.js"></script>
  <script src="/assets/js/isotope.pkgd.min.js"></script>
  <script src="/assets/js/jquery.magnific-popup.min.js"></script>
  <script src="/assets/js/owl.carousel.min.js"></script>
  <script src="/assets/js/jquery.menu-aim.js"></script>
  <script src="/assets/js/vertical-menu.js"></script>
  <script src="/assets/js/tweetie.js"></script>
  <script src="/assets/js/echo.min.js"></script>
  <!-- <script src="/assets/js/jquery.ajaxchimp.min.js"></script> -->
  <script src="/assets/js/jquery.countdown.min.js"></script>
  <script src="/assets/js/jquery.waypoints.min.js"></script>
  <script src="/assets/js/spectragram.min.js"></script>
  <script src="/assets/js/main.js"></script>

  <script src="/bower_components/typeahead.js/dist/typeahead.bundle.min.js"></script>
  <!-- Typeahead Initialization -->
  <script>
    jQuery(document).ready(function($) {
      // Set the Options for "Bloodhound" suggestion engine
      var engine = new Bloodhound({
        remote: {
          url: '/search-ajax?text=%QUERY%',
          wildcard: '%QUERY%'
        },
        datumTokenizer: Bloodhound.tokenizers.whitespace('text'),
        queryTokenizer: Bloodhound.tokenizers.whitespace
      });

      $(".typeahead-goods").typeahead({
        hint: true,
        highlight: true,
        minLength: 2
      }, {
        limit: 10,
        source: engine.ttAdapter(),
        displayKey: 'title',

        templates: {
          empty: [
            '<li>&nbsp;&nbsp;&nbsp;Ничего не найдено.</li>'
          ],
          suggestion: function (data) {
            return '<li class="list-group-item"><a href="/goods/' + data.id + '-' + data.slug + '"><img class="list-img" src="/img/products/' + data.path + '/' + data.image + '"> ' + data.title + '<br><span>Код: ' + data.barcode + '</span> <span>ОЕМ: ' + data.oem + '</span></a></li>'
          }
        }
      });
    });

    function removeFromBasket(r) {
      var productId = $(r).data("remove-goods-id");

      if (productId != '') {
        $.ajax({
          type: "get",
          url: '/remove-from-basket/'+productId,
          dataType: "json",
          data: {},
          success: function(data) {
            $('#cart-goods-id-'+productId).remove();
            console.log(data.countItems);
            $('#count-items').text(data.countItems);

            if (data.countItems == 0) {
              $('#last-li').html('<span>Корзина пуста</span>');
            }
          }
        });
      } else {
        alert("Ошибка сервера");
      }
    }

  </script>
  @yield('scripts')

  <!-- ZERO.kz -->
  <span id="_zero_69350">
  <noscript>
  <a href="http://zero.kz/?s=69350" target="_blank">
  <img src="http://c.zero.kz/z.png?u=69350" width="88" height="31" alt="ZERO.kz" />
  </a>
  </noscript>
  </span>

  <script type="text/javascript"><!--
  var _zero_kz_ = _zero_kz_ || [];
  _zero_kz_.push(["id", 69350]);
  _zero_kz_.push(["type", 1]);

  (function () {
      var a = document.getElementsByTagName("script")[0],
      s = document.createElement("script");
      s.type = "text/javascript";
      s.async = true;
      s.src = (document.location.protocol == "https:" ? "https:" : "http:")
      + "//c.zero.kz/z.js";
      a.parentNode.insertBefore(s, a);
  })(); //-->
  </script>
  <!-- End ZERO.kz -->

</body>
</html>