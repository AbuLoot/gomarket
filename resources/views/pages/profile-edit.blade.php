@extends('layout')

@section('content')

  <!--BREADCRUMB-->
  <div class="xs-breadcumb">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active" aria-current="page">Редактирование</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- PROFILE SECTION -->
  <section class="xs-section-padding about-content-left">
    <div class="container">
      <div class="row">

        <div class="col-lg-3 col-md-4">
          <div class="list-group">
            <a href="/my-profile" class="list-group-item list-group-item-action">Мой профиль</a>
            <a href="/my-orders" class="list-group-item list-group-item-action">Мои заказы</a>
            <a href="{{ route('logout') }}" class="list-group-item list-group-item-action" >
              {{ __('Выход') }}
            </a>
          </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12">
          <h3>Заполните профиль</h3>

          <form action="/my-profile" method="post">
            {!! csrf_field() !!}
            <div class="form-group">
              <label for="surname">Фамилия:</label>
              <input type="text" class="form-control" name="surname" id="surname" minlength="3" maxlength="60" value="{{ $user->surname }}" required>
            </div>
            <div class="form-group">
              <label for="name">Имя:</label>
              <input type="text" class="form-control" name="name" id="name" minlength="3" maxlength="60" value="{{ $user->name }}" required>
            </div>
            <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" name="email" id="email" minlength="8" maxlength="60" value="{{ $user->email }}" required>
            </div>
            <div class="form-group">
              <label for="about">Обо мне</label>
              <textarea class="form-control" id="about" name="about" rows="5">{{ $user->profile->about }}</textarea>
            </div>
            <div class="form-group">
              <label for="phone">Телефон</label>
              <input type="tel" class="form-control" id="phone" name="phone" minlength="5" maxlength="40" value="{{ $user->profile->phone }}" required>
            </div>
            <div class="form-group">
              <label for="status">Пол:</label><br>
              <label><input type="radio" name="sex" @if($user->profile->sex == "woman") checked @endif value="woman"> Женщина</label>
              <label><input type="radio" name="sex" @if($user->profile->sex == "man") checked @endif value="man"> Мужчина</label>
            </div>
            <div class="form-group">
              <label for="city_id">Город:</label>
              <select class="form-control" name="city_id" id="city">
                @foreach($cities as $city)
                  @if ($city->id == $user->profile->city_id)
                    <option value="{{ $city->id }}" selected>{{ $city->title }}</option>
                  @else
                    <option value="{{ $city->id }}">{{ $city->title }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Изменить</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </section>

@endsection