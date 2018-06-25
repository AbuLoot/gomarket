@extends('layout')

@section('title_description', '')

@section('meta_description', '')

@section('content')

  <!--BREADCRUMB-->
  <div class="xs-breadcumb">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active" aria-current="page">Вход и Регистрация</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- LOGIN REGISTRATION SECTION -->
  <section class="xs-section-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-10 mx-auto">
          <div class="row customer-info-forms">
            <div class="col-md-6">
              <div class="xs-customer-form-wraper">
                <h3>Войти в аккаунт</h3>
                <form method="POST" action="{{ route('login') }}" class="xs-customer-form">
                  @csrf
                  <div class="input-group">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="ВВЕДИТЕ EMAIL" minlength="8" maxlength="80" required autofocus>

                    @if ($errors->has('email'))
                      <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="input-group">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="ВВЕДИТЕ ПАРОЛЬ" minlength="6" maxlength="60" required>

                    @if ($errors->has('password'))
                      <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                      </span>
                    @endif
                  </div>
                  <button type="submit" class="btn btn-primary btn-block">Войти</button>
                </form>
              </div>
            </div>
            <p class="form-separetor">или</p>
            <div class="col-md-6">
              <div class="xs-customer-form-wraper">
                <h3>Зарегистрироваться</h3>
                <form action="{{ route('register') }}" method="POST" class="xs-customer-form">
                  @csrf
                  <div class="input-group">
                    <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" placeholder="ВВЕДИТЕ ИМЯ" minlength="2" maxlength="60" required autofocus>

                    @if ($errors->has('name'))
                      <span class="invalid-feedback">
                        <strong>{{ $errors->first('name') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="input-group">
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="ВВЕДИТЕ EMAIL" minlength="8" maxlength="80" required>

                    @if ($errors->has('email'))
                      <span class="invalid-feedback">
                        <strong>{{ $errors->first('email') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="input-group">
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="ВВЕДИТЕ ПАРОЛЬ" minlength="6" maxlength="60" required>

                    @if ($errors->has('password'))
                      <span class="invalid-feedback">
                        <strong>{{ $errors->first('password') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="input-group">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="ВВЕДИТЕ ПОВТОРНО ПАРОЛЬ" minlength="6" maxlength="60" required>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block">Зарегистрироваться</button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection