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
          <li class="breadcrumb-item active" aria-current="page">Моя страница</li>
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
            <a href="/#" class="list-group-item list-group-item-action active">Мой профиль</a>
            <a href="/my-orders" class="list-group-item list-group-item-action">Мои заказы</a>
            <a href="{{ route('logout') }}" class="list-group-item list-group-item-action" >
              {{ __('Выход') }}
              <!-- onclick="event.preventDefault(); document.getElementById('logout-form').submit();" -->
              <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form> -->
            </a>
          </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12">
          <h3 class="panel-heading">Информация</h3>

          <dl class="dl-horizontal">
            <dt>Имя</dt>
            <dd>{{ $user->surname . ' ' . $user->name }}</dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>Email</dt>
            <dd>{{ $user->email }}</dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>Номер телефона</dt>
            <dd>{{ $user->profile->phone }}</dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>Обо мне</dt>
            <dd>{{ $user->profile->about }}</dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>Город</dt>
            <dd>{{ $user->profile->city->title }}</dd>
          </dl>
          <dl class="dl-horizontal">
            <dt>Пол</dt>
            <dd>{{ ($user->profile->sex == "woman") ? 'Женщина' : 'Мужчина' }}</dd>
          </dl>

          <div>
            <a class="btn btn-primary" href="/my-profile/edit">Изменить</a>
          </div>
        </div>

      </div>
    </div>
  </section>

@endsection