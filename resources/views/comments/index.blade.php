<div class="page-header">
  <h4>댓글</h4>
</div>

{{-- 로그인 중인지 판단--}}
<div class="form__new__comment">
  @if($currentUser)
    @include('comments.partial.create')
  @else
    @include('comments.partial.login')
  @endif
</div>

<div class="list__comment">
  @forelse($comments as $comment)
    @include('comments.partial.comment', [
      'parentId' => $comment->id,
      'isReply' => false,
    ])
  @empty
  @endforelse
</div>


@section('script')
  @parent
  <script>
    $('.btn__delete__comment').on('click', function(e) {
      var commentId = $(this).closest('.item__comment').data('id'),
        articleId = $('article').data('id');
      if (confirm('댓글을 삭제합니다.')) {
        $.ajax({
          type: 'DELETE',
          url: "/comments/" + commentId,
        }).then(function() {
          window.location.href = '/articles';
        });
      }
    });
    // 대댓글 폼을 토글
    $('.btn__reply__comment').on('click', function(e) {
      var el__create = $(this).closest('.item__comment').find('.media__create__comment').first(),
        el__edit = $(this).closest('.item__comment').find('.media__edit__comment').first();
      el__edit.hide('fast');
      el__create.toggle('fast').end().find('textarea').focus();
    });
    
    // 댓글 수정 폼을 토글
    $('.btn__edit__comment').on('click', function(e) {
      var el__create = $(this).closest('.item__comment').find('.media__create__comment').first(),
        el__edit = $(this).closest('.item__comment').find('.media__edit__comment').first();
      el__create.hide('fast');
      el__edit.toggle('fast').end().find('textarea').first().focus();
    });
    // Send save a vote request to the server
    $('.btn__vote__comment').on('click', function(e) {
      var self = $(this),
        commentId = self.closest('.item__comment').data('id');
      $.ajax({
        type: 'POST',
        url: '/comments/' + commentId + '/votes',
        data: {
          vote: self.data('vote')
        }
      }).then(function (data) {
        self.find('span').html(data.value).fadeIn();
        self.attr('disabled', 'disabled');
        self.siblings().attr('disabled', 'disabled');
      });
    });
  </script>
@endsection