@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="col-md-10 offset-md-1">
      <div class="card">

        <div class="card-body">
          <h2 class="">
            <i class="far-edit"></i>
            @if ($topic->id)
            编辑话题
            @else
            新建话题
            @endif
          </h2>

          <hr>

          @if($topic->id)
            <form action="{{ route('topics.update', $topic->id) }}" method="post" accept="UTF-8">
              <input type="hidden" name="_method" value="PUT">
          @else
            <form action="{{ route('topics.store') }}" method="post" accept="UTF-8">
          @endif
              <input type="hidden" name="_token" value="{{ csrf_token() }}">

              @include('shared._errors')

              <div class="form-group">
                <input type="text" name="title" class="form-control" value="{{ old('title', $topic->title) }}" placeholder="请填写标题" required />
              </div>

              <div class="form-group">
                <select name="category_id" class="form-control" required>
                  <option value="" hidden disabled selected>请选择分类</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group">
                <textarea name="body" id="editor" rows="6" class="form-control" placeholder="请填入至少三个字符的内容。" required>
                  {{ old('body', $topic->body) }}
                </textarea>
              </div>

              <div class="well well-sm">
                <button type="submit" class="btn btn-primary"><i class="far fa-save mr-2" aria-hidden="true"></i> 保存</button>
              </div>
            </form>

        </div>
      </div>
    </div>
  </div>
@stop

@section('styles')
  <link rel="stylesheet" href="{{ asset('css/simditor.css') }}">
@stop

@section('scripts')
  <script type="text/javascript" src="{{ asset('js/module.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/hotkeys.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/uploader.js') }}"></script>
  <script type="text/javascript" src="{{ asset('js/simditor.js') }}"></script>

  <script>
    $(document).ready(function() {
      var editor = new Simditor({
        textarea: $('#editor'),
      });
    })
  </script>  
@stop