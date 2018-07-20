@extends('layout')

@section('content')

  <!--BREADCRUMB-->
  <div class="xs-breadcumb">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active" aria-current="page">Корзина</li>
        </ol>
      </nav>
    </div>
  </div>

  <section class="xs-section-padding">
    <div class="container">
      @if ($products->count() > 0)
      <h1>Корзина <small>Оформление заказа</small></h1>

      <h4 class="text-right"><a href="/clear-basket">Очистить корзину?</a></h4>

      <form action="/store-order" method="post">
        {!! csrf_field() !!}

        <div class="table-responsive">
          <table class="table table-striped table-condensed">
            <thead>
              <tr class="active">
                <td>Название</td>
                <td>Цена</td>
                <td>Количество</td>
                <td>Сумма</td>
                <td class="text-right">Действие</td>
              </tr>
            </thead>
            <tbody>
              @forelse ($products as $product)
                <tr>
                  <td>
                    <img src="/img/products/{{ $product->path.'/'.$product->image }}" style="width:80px;height:80px;">
                    <a href="/goods/{{ $product->id.'/'.$product->slug }}">{{ $product->title }}</a>
                  </td>
                  <td>{{ $product->price }} тг</td>
                  <td style="width:100px;"><input type="number" class="form-control" name="count[{{ $product->id }}]" min="1" max="1000" value="1"></td>
                  <td>{{ $product->sum }}</td>
                  <td class="text-right">
                    <a href="/basket/{{ $product->id }}" class="btn btn-dark btn-compact" onclick="return confirm('Удалить запись?')"><i class="material-icons">clear</i></a>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="5"></td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="card">
          <div class="card-body">
            @guest
              <h4>Заполните форму или оформите заказ через <a href="/login-or-reg">аккаунт</a></h4>
              <div class="row">
                <div class="col-md-4 form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                  <label for="name">ФИО</label>
                  <input type="text" class="form-control" placeholder="ФИО *" name="name" id="name" value="{{ old('name') }}" minlength="2" maxlength="40" required>
                  @if ($errors->has('name'))
                    <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                  @endif
                </div>
                <div class="col-md-4 form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                  <label for="phone">Телефона</label>
                  <input type="tel" class="form-control" placeholder="Телефона *" name="phone" id="phone" value="{{ old('phone') }}" minlength="5" maxlength="20" required>
                  @if ($errors->has('phone'))
                    <span class="help-block text-danger">{{ $errors->first('phone') }}</span>
                  @endif
                </div>
                <div class="col-md-4 form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" placeholder="Email *" name="email" id="email" value="{{ old('email') }}" required>
                  @if ($errors->has('email'))
                    <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                  @endif
                </div>
              </div>
            @else
              <h4>Заполните форму</h4>
              <div class="row">
                <div class="col-md-4 form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                  <label for="name">ФИО</label>
                  <input type="text" class="form-control" placeholder="ФИО *" name="name" id="name" value="{{ (old('name')) ? old('name') : \Auth::user()->surname . ' ' . \Auth::user()->name }}" minlength="2" maxlength="40" required>
                  @if ($errors->has('name'))
                    <span class="help-block text-danger">{{ $errors->first('name') }}</span>
                  @endif
                </div>
                <div class="col-md-4 form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                  <label for="phone">Телефона</label>
                  <input type="tel" class="form-control" placeholder="Телефона *" name="phone" id="phone" value="{{ (old('phone')) ? old('phone') : \Auth::user()->phone }}" minlength="5" maxlength="20" required>
                  @if ($errors->has('phone'))
                    <span class="help-block text-danger">{{ $errors->first('phone') }}</span>
                  @endif
                </div>
                <div class="col-md-4 form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                  <label for="email">Email</label>
                  <input type="email" class="form-control" placeholder="Email *" name="email" id="email" value="{{ (old('email')) ? old('email') : \Auth::user()->email }}" required>
                  @if ($errors->has('email'))
                    <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                  @endif
                </div>
              </div>
            @endguest
            <div class="row">
              <div class="col-md-4 form-group">
                <label for="city_id">Регион</label>
                <select id="city_id" name="city_id" class="form-control" required>
                  <option value=""></option>
                  @foreach($countries as $country)
                    <optgroup label="{{ $country->title }}">
                      @foreach($country->cities as $city)
                        <option value="{{ $city->id }}">{{ $city->title }}</option>
                      @endforeach
                    </optgroup>
                  @endforeach
                </select>
              </div>
              <div class="col-md-4 form-group {{ $errors->has('address') ? ' has-error' : '' }}">
                <label for="address">Адрес</label>
                <input type="text" class="form-control" placeholder="Адрес *" name="address" id="address" value="{{ old('address') }}" minlength="2" maxlength="40" required>
                @if ($errors->has('address'))
                  <span class="help-block text-danger">{{ $errors->first('address') }}</span>
                @endif
              </div>
            </div>

            <h4>Способ доставки:</h4>
            <div class="row">
              <div class="col-md-6">
                <label class="radio-inline">
                  <input type="radio" name="get" value="courier" checked> Доставить Курьером
                </label>
                <label class="radio-inline">
                  <input type="radio" name="get" value="self"> Самовывоз
                </label>
              </div>
            </div><br>

            <h4>Способ оплаты:</h4>
            <div class="row">
              <div class="col-md-12">
                <label class="radio-inline">
                  <input type="radio" name="pay" value="card" checked> Оплата картой (Visa, MasterCard)
                </label>
                <label class="radio-inline">
                  <input type="radio" name="pay" value="cash"> Наличными
                </label>
              </div>
            </div>
          </div>
        </div><br>

        <div class="card">
          <div class="card-body text-center">
            <h3>Итого: <b>{{ $products->sum('price') }} ₸</b></h3>
            <button type="submit" class="btn btn-primary btn-lg text-uppercase">Оформить заказ</button>
          </div>
        </div>
      </form>
      @else
      <h1 class="text-center">Корзина пуста</h1>
      <p class="text-center"><a href="/" class="btn btn-lg btn-primary">Перейти к покупкам</a></p>
      @endif
    </div>
  </section>

@endsection