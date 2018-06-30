@extends('layout')

@section('title_description', $page->title_description)

@section('meta_description', $page->meta_description)

@section('content')

  <!--BREADCRUMB-->
  <div class="xs-breadcumb">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
        </ol>
      </nav>
    </div>
  </div>

  <section class="xs-section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="xs-heading v-big">
            <h2 class="xs-heading-title xs-mb-10">{{ $page->title }}</h2>
            <hr>
            {!! $page->content !!}
          </div>

          <form action="/send-app" method="POST" class="xs-contact-form">
            {{ csrf_field() }}
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                  <!-- <h3 class="h3">Name</h3> -->
                  <input type="text" class="form-control input-lg" name="name" id="xs_contact_name" placeholder="Введите имя" minlength="2" maxlength="40" value="{{ (old('name')) ? old('name') : '' }}" required>
                  @if ($errors->has('name'))
                    <span class="help-block">{{ $errors->first('name') }}</span>
                  @endif
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                  <!-- <h3 class="h3">Email</h3> -->
                  <input type="email" class="form-control input-lg" name="email" id="xs_contact_email" placeholder="Введите Email" minlength="5" maxlength="80" value="{{ (old('email')) ? old('email') : '' }}" required>
                  @if ($errors->has('email'))
                    <span class="help-block">{{ $errors->first('email') }}</span>
                  @endif
                </div>
              </div>
            </div>

            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
              <!-- <h3 class="h3">Номер телефона</h3> -->
              <input type="tel" pattern="(\+?\d[- .]*){7,13}" class="form-control input-lg" name="phone" placeholder="Введите номер телефона" minlength="5" maxlength="20" value="{{ (old('phone')) ? old('phone') : '' }}" required>
              @if ($errors->has('phone'))
                <span class="help-block">{{ $errors->first('phone') }}</span>
              @endif
            </div>
            <div class="form-group">
              <!-- <h3 class="h3">Текст</h3> -->
              <textarea class="form-control form-control-lg" name="message" id="x_contact_massage" rows="3" placeholder="Ваше сообщение"></textarea>
            </div>
            <div class="xs-btn-wraper">
              <input type="submit" name="submit" value="Отправить сообщение" id="xs_contact_submit" class="btn btn-primary badge badge-pill btn-lg">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- MAPS -->
  <section>
    <script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Aa324317b2b149b9cfcd3531d7d8c6664a4ab53409ceb8bdd912e2ca392a3a464&amp;width=100%25&amp;height=500&amp;lang=ru_RU&amp;scroll=false"></script>
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
