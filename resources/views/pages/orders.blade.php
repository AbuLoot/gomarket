@extends('layout')

@section('content')

  <!--BREADCRUMB-->
  <div class="xs-breadcumb">
    <div class="container">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="/">Главная</a></li>
          <li class="breadcrumb-item active" aria-current="page">Мои заказы</li>
        </ol>
      </nav>
    </div>
  </div>

  <!-- ORDERS -->
  <section class="xs-section-padding about-content-left">
    <div class="container">
      <div class="row">

        <div class="col-lg-3 col-md-4">
          <div class="list-group">
            <a href="/my-profile" class="list-group-item list-group-item-action">Мой профиль</a>
            <a href="/#" class="list-group-item list-group-item-action active">Мои заказы</a>
            <a href="{{ route('logout') }}" class="list-group-item list-group-item-action">
              {{ __('Выход') }}
            </a>
          </div>
        </div>
        <div class="col-lg-9 col-md-8 col-sm-12">
          <h3>Мои заказы</h3>

          @forelse ($orders as $order)
            <dl class="row">
              <dt class="col-md-3"><h5>Номер заказа</h5></dt><dd class="col-md-3">{{ $order->id }}</dd>
              <dt class="col-md-3">Город</dt><dd class="col-md-3">{{ $order->city_id }}</dd>
              <dt class="col-md-3">Сумма</dt><dd class="col-md-3">{{ $order->amount }}〒</dd>
              <dt class="col-md-3">Статус заказа</dt><dd class="col-md-3">{{ trans('orders.statuses.'.$order->status) }}</dd>
            </dl>

            <?php $countAllProducts = unserialize($order->count); $i = 0; ?>
            @foreach ($countAllProducts as $id => $countProduct)
              @if (isset($order->products[$i]) AND $order->products[$i]->id == $id)
                <div class="xs-product-widget media">. 
                  <img class="d-flex" src="/img/products/{{ $order->products[$i]->path.'/'.$order->products[$i]->image }}" style="height: 150px;">
                  <div class="media-body align-self-center product-widget-content">
                    <h4 class="product-title"><a href="/goods/{{ $order->products[$i]->id.'-'.$order->products[$i]->slug }}">{{ $order->products[$i]->title }}</a></h4>
                    <h5>{{ $countProduct . ' шт.' }}</h5>
                    <span class="price">{{ $order->products[$i]->price }}〒</span>
                  </div>
                </div>
              @endif
              <?php $i++; ?>
            @endforeach<hr>
          @empty
            <h4>Нет записи</h4>
          @endforelse


  <!-- Pagination -->
  {{ $orders->links('vendor.pagination.bootstrap-4') }}

        </div>
      </div>
    </div>
  </section>

@endsection