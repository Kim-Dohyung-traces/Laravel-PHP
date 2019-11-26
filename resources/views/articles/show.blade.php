@extends('layouts.app')

@section('content')
@php $viewName = 'articles.show'; @endphp
<div class="page-header">
    <h4>
        <a href="{{ route('articles.index') }}">
            게시글
        </a>
        <small>
            / {{ $article->id }}번째 게시글
        </small>
    </h4>
</div>


<div class ="row container__article">
    <div class = "col-md-3 sidebar__article">
        <aside>
            @include('tags.partial.index')
        </aside>
    </div>

    <div class="col-md-9 list__article">
        <article data-id="{{ $article->id }}">
        @include('articles.partial.article', compact('article'))

        <div>
            <p>{!! $article->content !!}</p>
        </div>
        @include('tags.partial.list', ['tags' => $article->tags])
        </article>

        <div class="text-center action__article">
            @can('update', $article)
            <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-info">
                <i class="fa fa-pencil"></i>
                글 수정
            </a>
            @endcan

            @can('delete', $article)
            <button class="btn btn-danger button__delete">
                <i class="fa fa-trash-o"></i>
                글 삭제
            </button>
            @endcan
            <a href="{{ route('articles.index') }}" class="btn btn-default">
                <i class="fa fa-list"></i>
                글 목록
            </a>
        </div>

        <div class="container__comment">
            @include('comments.index')
        </div>
    </div>
</div>
@stop

@section('script')
<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.button__delete').on('click', function(e) {
    var articleId = $('article').data('id');
    if (confirm('글을 삭제합니다.')) { //글을 삭제합니다 경고창에서 yes를누르면 true
        $.ajax({
            type: "DELETE",
            url: '/articles/' + articleId
        }).then(function() {
            window.location.href = '/articles'; //삭제 성공시 /articles로 리다이렉션
        });
    }
});
</script>
@stop
