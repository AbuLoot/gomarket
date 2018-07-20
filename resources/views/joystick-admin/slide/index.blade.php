@extends('joystick-admin.layout')

@section('content')
  <h2 class="page-header">Слайд</h2>

  @include('joystick-admin.partials.alerts')

  <p class="text-right">
    <a href="/admin/slide/create" class="btn btn-success btn-sm">Добавить</a>
  </p>
  <div class="table-responsive">
    <table class="table table-striped table-condensed">
      <thead>
        <tr class="active">
          <td>№</td>
          <td>Позиция</td>
          <td>Название</td>
          <td>URI</td>
          <td>Заголовок</td>
          <td>Номер</td>
          <td>Язык</td>
          <td>Статус</td>
          <td class="text-right">Функции</td>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; ?>
        @forelse ($slide as $item)
          <tr>
            <th>{{ $i++ }}</th>
            <th>{{ $item->direction }}</th>
            <th>{{ $item->title }}</th>
            <th>{{ $item->slug }}</th>
            <th>{{ $item->marketing }}</th>
            <th>{{ $item->sort_id }}</th>
            <th>{{ $item->lang }}</th>
            @if ($item->status == 1)
              <th class="text-success">Активен</th>
            @else
              <th class="text-danger">Неактивен</th>
            @endif
            <th class="text-right text-nowrap">
              <a class="btn btn-link btn-xs" href="/goods/{{ $item->link }}" title="Просмотр товара" target="_blank"><i class="material-icons md-18">link</i></a>
              <a class="btn btn-link btn-xs" href="{{ route('slide.edit', $item->id) }}" title="Редактировать"><i class="material-icons md-18">mode_edit</i></a>
              <form method="POST" action="{{ route('slide.destroy', $item->id) }}" accept-charset="UTF-8" class="btn-delete">
                <input name="_method" type="hidden" value="DELETE">
                <input name="_token" type="hidden" value="{{ csrf_token() }}">
                <button type="submit" class="btn btn-link btn-xs" onclick="return confirm('Удалить запись?')"><i class="material-icons md-18">clear</i></button>
              </form>
            </th>
          </tr>
          <tr>
            <td colspan="9">
              <img src="/img/slide/{{ $item->image }}" class="img-responsive"><br>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="9">Нет записи</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{ $slide->links() }}

@endsection