$(document).ready( function() {
    var $commentBtn = $("#btn-comment");
    var csrfToken = $("meta[name='csrf-token']").attr('content');
    var post_id = $("#post_id").val();
    var author_id = $("#author_id").val();
    
    // 댓글 추가, 수정, 삭제할 경우나 수정모드에서 취소할 경우 
    var updateEvents = function() {
        $btnUpdate = $("#comment-list .comment .btn-update");
        $btnDelete = $("#comment-list .comment .btn-delete");
        $comment = $btnUpdate.parent().parent();
        len = $comment.length;
        $btnUpdate.off();
        $btnDelete.off();
        
        // 댓글 수정
        $btnUpdate.on('click', function(e) {      
            e.stopPropagation();
            getComment($(this));
            return false;
        });
        
        // 댓글 삭제
        $btnDelete.on('click', function(e) {            
            e.stopPropagation();
            deleteComment($(this));
            return false;
        });
    };
    
    var saveComment = function() {
        var content = $("#comment-content").val();
        if (!content) {
            alert("내용을 입력하세요");
            return false;
        }
        //console.log(csrfToken+'-'+post_id+'-'+author_id+'-'+content);
        var options = {
            url: '/comment/write',
            type : 'POST',
            dataType : 'json',
            data : {
                _csrf : csrfToken,
                'Comment[post_id]' : post_id,
                'Comment[author_id]' : author_id,
                'Comment[content]' : content
            },
            async: false,
            cache: false,
            success : function(result, textStatus, jqXHR){
                console.log(result);
                if (!result.error) {                    
                    $("#comment-list").append(tmpl('template-comment', result));
                    $("#comment-form textarea").val('');
                    updateEvents();
                    alert(result.msg);
                }
                else {
                    alert(result.msg);                    
                }
            }
        };
        $.ajax(options); 
    };
    
    var modifyComment = function($obj) {
        var id = $obj.attr('id');
        var splitedId = id.split('_');
        var parent = $obj.parent().parent();
        var content = parent.find($("textarea")).val();
        if (!content) {
            alert("내용을 입력하세요");
            return false;
        }
        var options = {
            url: '/comment/modify',
            type : 'POST',
            dataType : 'json',
            data : {
                _csrf : csrfToken,
                'co_id' : splitedId[1],
                'content' : content
            },
            async: false,
            cache: false,
            success : function(result, textStatus, jqXHR){
                if (!result.error) {
                    $("#comment_" + result.co_id).empty().replaceWith(tmpl('template-comment', result));
                    updateEvents();
                    alert(result.msg);
                }
                else {
                    alert(result.msg);
                }
            }
        };
        $.ajax(options); 
    };
    
    var deleteComment = function($obj) {
        var id = $obj.attr('id');
        var splitedId = id.split('_');
        var options = {
            url: '/comment/remove',
            type : 'POST',
            dataType : 'json',
            data : {
                _csrf : csrfToken,
                co_id : splitedId[1]
            },
            async: false,
            cache: false,
            success : function(result, textStatus, jqXHR){
                if (!result.error) {
                    $("#comment_" + result.co_id).remove();

                   updateEvents();
                    alert(result.msg);
                }
                else {
                    alert(result.msg);
                }
            }
        };
        $.ajax(options); 
    };
    
    var getComment = function($obj) {
        var id = $obj.attr('id');
        var splitedId = id.split('_');
        var options = {
            url: '/comment/get',
            type : 'POST',
            dataType : 'json',
            data : {
                _csrf : csrfToken,
                co_id : splitedId[1]
            },
            async: false,
            cache: false,
            success : function(result, textStatus, jqXHR) {
                if (!result.error) {
                    // 수정모드로 되어 있는 코멘트들을 원상복귀한다.
                    var $btnCancel = $(".comment .btn-cancel");
                    if ($btnCancel.length) {
                        $btnCancel.trigger('click');
                    }
                    //alert(result.auth);
                    // 수정양식
                    $("#comment_" + result.co_id).empty().append(tmpl('template-form', result));
                    updateEvents();
                    
                    // 취소 버튼 이벤트
                    $(".comment .btn-cancel").on('click', function(e){
                        e.stopPropagation();
                        var id = $(this).attr('id');
                        var splitedId = id.split('_');
                        var parent = $(this).parent().parent();
                        var htmlContent = parent.find($("textarea")).val();
                        var data = {
                            co_id : splitedId[1],
                            name : parent.find($("input[name='name']")).val(),
                            date : parent.find($("input[name='date']")).val(),
                            content : htmlContent
                        };
                        $("#comment_" + result.co_id).empty().append(tmpl('template-comment', data));
                        updateEvents();
                        return false;
                    });
                    
                    // 코멘트 수정 버튼 이벤트
                    $("#btn-comment_" + result.co_id).on('click', function(e){
                        e.stopPropagation();
                        modifyComment($(this));
                        return false;
                    });
                }
                else {
                    alert(result.msg);
                }
            }
        };
        $.ajax(options); 
    };
    
    // 댓글 쓰기
    $commentBtn.on('click', function(e){  
            e.stopPropagation();
            saveComment();
            return false;
    });
    
    // 댓글 수정
    var $btnUpdate = $("#comment-list .comment .btn-update"),
        $btnDelete = $("#comment-list .comment .btn-delete"),
        $comment = $btnUpdate.parent().parent(),
        len = $comment.length;
    
    if (len) {
        // 댓글 수정
        $btnUpdate.on('click', function(e) {      
            e.stopPropagation();
            getComment($(this));
            return false;
        });
        
        // 댓글 삭제
        $btnDelete.on('click', function(e) {            
            e.stopPropagation();
            deleteComment($(this));
            return false;
        });
    }
});


