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

<div class="xs-section-padding xs-blog-single-2">
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
                    <i class="fa fa-comments"></i><a href="#"> {{ $newsSingle->comments->count() }} Комментарии</a>
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
        @auth
          <br>
          <h4>Добавить комментарий</h4><br>
          <form action="/comment-news" method="POST">
            {!! csrf_field() !!}
            <input name="id" type="hidden" value="{{ $newsSingle->id }}">
            <div class="row">
              <div class="form-group col-md-12">
                <label for="name">Ваше имя</label>
                <input type="text" class="form-control" id="name" name="name" minlength="3" maxlength="60" placeholder="Введите имя" value="{{ Auth::user()->name }}" required>
              </div>
              <!-- <div class="form-group col-md-6">
                <label for="stars">Сколько звезд?</label>
                <select class="form-control" name="stars" id="stars">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div> -->
            </div>
            <div class="form-group">
              <label for="comment">Сообщение</label>
              <textarea rows="3" class="form-control" id="comment" name="comment" maxlength="2000" required>{{ old('comment') }}</textarea>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary btn-sm">Добавить</button>
            </div>
          </form>
        @endauth
        <br>
        <h4>Комментарии</h4><br>
        @foreach ($newsSingle->comments as $comment)
          <div class="card">
            <div class="card-body">
              <blockquote class="blockquote mb-0">
                <p>{{ $comment->comment }}</p>
                <footer class="blockquote-footer">
                  {{ $comment->name }}
                </footer>
              </blockquote>
            </div>
          </div><br>
        @endforeach
      </div>
      <div class="col-md-12 col-lg-4">
        <sidebar class="sidebar sidebar-right">

        </sidebar>
      </div>
    </div>
  </div>
</div>

@endsection