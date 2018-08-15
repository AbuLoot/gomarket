@extends('layout')

@section('content')

<div class="xs-breadcumb">
  <div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Главная</a></li>
        <li class="breadcrumb-item"><a href="/news">Новости</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $newsCategory->title }}</li>
      </ol>
    </nav>
  </div>
</div>

<div class="xs-blog-list xs-section-padding-2">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8">
        <div class="blog-post-list">
          @foreach($news as $newsSingle)
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
                        <i class="fa fa-folder-open"></i><a href="#"> Info</a>
                      </span>
                    </div>
                  </div>
                  <h2 class="entry-title xs-post-entry-title">
                    <a href="/news/{{ $newsSingle->slug }}">{{ $newsSingle->title }}</a>
                  </h2>
                </div>

                <div class="entry-content">{{ $newsSingle->headline }}</div>
                <div class="xs-btn-wraper">
                  <a href="/news/{{ $newsSingle->slug }}" class="btn btn-primary">Читать дальше</a>
                </div>
              </div>
            </article>
          @endforeach

          <!-- Pagination -->
          {{ $news->links('vendor.pagination.bootstrap-4') }}
        </div>
      </div>
      <div class="col-md-12 col-lg-4">
        <!-- <sidebar class="sidebar sidebar-right">

        </sidebar> -->
      </div>
    </div>
  </div>
</div>
@endsection