<!-- 코멘트 입력 양식 -->
<script id="template-form" type="text/x-tmpl">
<form name="form" id="comment-form_{%=o.co_id%}" action="/index.php?r=comment/modify" method="post">
<input type="hidden" name="post_id" id="post_id_{%=o.id%}" value="{%=o.post_id%}" />
<input type="hidden" name="author_id" id="author_id_{%=o.id%}" value="{%=o.author_id%}" />
<input type="hidden" name="name" id="name_{%=o.id%}" value="{%=o.name%}" />
<input type="hidden" name="date" id="date_{%=o.id%}" value="{%=o.date%}" />
<a id="btn-cancel_{%=o.co_id%}" class="btn-cancel"><img src="/images/common/cancel.jpg" alt="취소" /></a>
<div class="comment-form-content2">
    <textarea name="content" id="comment-content" class="comment-content">{%=o.content%}</textarea>
    <button name="btn-comment" id="btn-comment_{%=o.co_id%}" class="btn-comment">댓글수정</button>
</div>
</form>
</script>
