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

  <!-- PAGE SECTION -->
  <section class="xs-section-padding">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 mx-auto">
          <div class="xs-heading v-big">
            <h2 class="xs-heading-title xs-mb-10">{{ $page->title }}</h2>
            <hr>
          </div>
          {!! $page->content !!}
        </div>
      </div>
    </div>
  </section>

@endsection