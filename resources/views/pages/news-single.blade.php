@extends('layout')

@section('content')

<div class="xs-breadcumb">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Главная</a></li>
        <li class="breadcrumb-item"><a href="/news">Новости</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $newsSingle->title }}</li>
      </ol>
    </nav>
  </div>
</div>

<div class="xs-section-padding xs-blog-single">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8">
        <article class="post format-standard hentry xs-blog-post-details">
          <div class="post-media post-image">
            @if(empty($newsSingle->video))
              <img src="/img/news/{{ $newsSingle->image }}" class="img-responsive" alt="">
            @else
              <div class="thumb-wrap">
                {!! $newsSingle->video !!}
              </div>
            @endif
          </div>

          <div class="post-body">
            <div class="entry-header">
              <div class="post-meta">
                <div class="xs-post-meta-list">
                  <span class="post-author">
                    <i class="fa fa-user"></i><a href="#"> Admin</a>
                  </span>
                  <span class="post-meta-date"><i class="fa fa-calendar"></i> {{ $newsSingle->getRusDateAttribute() }}</span>
                  <span class="post-cat">
                    <i class="fa fa-folder-open"></i><a href="#"> Big Sale</a>
                  </span>
                </div>
              </div>
              <h2 class="entry-title xs-post-entry-title">{{ $newsSingle->title }}</h2>
            </div>
            
            <div class="entry-content">
              {!! $newsSingle->content !!}
            </div>
          </div>
        </article>
      </div>
      <div class="col-md-12 col-lg-4">
        <sidebar class="sidebar sidebar-right">

        </sidebar>
      </div>
    </div>
  </div>
</div>

@endsection