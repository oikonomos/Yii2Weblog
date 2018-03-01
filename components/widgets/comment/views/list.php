<?php
/* @var $comments Array */
/* @var $post_id Integer */
/* @var $author_id Integer */
?>
<!-- 코멘트 입력 양식 -->
<div id="comment-form">
    <form name="form" id="comment-form_0">
    <input type="hidden" name="post_id" id="post_id" value="<?php echo $post_id ?>" />
    <input type="hidden" name="author_id" id="author_id" value="<?php echo $author_id ?>" />
    <div class="comment-form-content">
        <?php if ( !Yii::$app->user->isGuest ): ?>
        <textarea name="content" id="comment-content" class="comment-content"></textarea>
        <button name="btn-comment" id="btn-comment" class="btn-comment">댓글입력</button>
        <?php else: ?>
        <textarea name="content" id="content" class="comment-content" disabled>로그인 하셔야 댓글쓰기가 가능합니다.</textarea>
        <button name="btn-comment" id="btn-comment" class="btn-comment" disabled>댓글입력</button>
        <?php endif; ?>
    </div>
    </form>
</div>

<!-- comment-list::start -->
<div id = "comment-list">

    <?php foreach ( $comments as $comment ) { ?>

    <div class="comment" id="comment_<?php echo $comment['co_id'] ?>">
        <div class="comment-header">                
            <i class="fa fa-user"></i>&nbsp; 
            <span class="commentor"><?php echo $comment['writer'] ?></span>&nbsp; 
            <span class="comment-date"><?php echo $comment['created_at'] ?></span>&nbsp; &nbsp; &nbsp; &nbsp; 
            <button id="btn-update_<?php echo $comment['co_id'] ?>" class="btn-update"><i class="fa fa-pencil-square fa-lg" aria-hidden="true"></i></button>
            <button id="btn-delete_<?php echo $comment['co_id'] ?>" class="btn-delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>
        </div>
        <div class="comment-content">
            <pre>
<?php echo $comment['content'] ?>
            </pre>
        </div>
    </div>

    <?php } ?>

</div>
<!-- comment-list::end -->
