<!-- 코멘트 -->
<script id="template-comment" type="text/x-tmpl">        
<div class="comment" id="comment_{%= o.co_id %}">
    <div class="comment-header">
        <i class="fa fa-user"></i>&nbsp; 
        <span class="commentor">{%= o.name %}</span>&nbsp; 
        <span class="comment-date">{%= o.date %}</span>&nbsp; &nbsp; &nbsp; &nbsp; 
        <button id="btn-update_{%=o.co_id%}" class="btn-update"><i class="fa fa-pencil-square fa-lg" aria-hidden="true"></i></button>
        <button id="btn-delete_{%=o.co_id%}" class="btn-delete"><i class="fa fa-trash fa-lg" aria-hidden="true"></i></button>
    </div>
    <div class="comment-content">
    <pre>
{%= o.content %}
    </pre>
    </div>    
</div>
</script>
