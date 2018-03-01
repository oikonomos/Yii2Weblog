<script id="template-media-wrapper" type="text/x-tmpl">
<div id="media-wrapper">
    <div id="media-list-head">
        <div id="title">
            <h2><?=Yii::t('app', 'Media Attachment')?></h2>
        </div>
        <form>
        <select id="media-types">
            <option value="all" {% if( o.type == "" && o.type == "all" ) { %} selected {% } %}><?=Yii::t('app', 'All')?></option>
            <option value="document" {% if( o.type == "document" ) { %} selected {% } %}><?=Yii::t('app', 'Document')?></option>
            <option value="image" {% if( o.type == "image" ) { %} selected {% } %}><?=Yii::t('app', 'Image')?></option>
            <option value="audio" {% if( o.type == "audio" ) { %} selected {% } %}><?=Yii::t('app', 'Audio')?></option>
            <option value="video" {% if( o.type == "video" ) { %} selected {% } %}><?=Yii::t('app', 'Video')?></option>
            <option value="archive" {% if( o.type == "archive" ) { %} selected {% } %}><?=Yii::t('app', 'Archive')?></option>
        </select>
        <input type="text" id="mstx" name="mstx" value="{%=o.mstx%}" />
        <button id="btn-mediasearch"><?=Yii::t('app', 'Search')?></button>
        </form>
    </div>
    <div id="media-list-content">
        <ul id="media-list">
        {% for (var i=0, l=o.data.length; i<l; i++) { %}
            <li class="thumb-item">
                <div class="thumb-outer-frame tf-outer-border">
                    <div class="thumb-inner-frame tf-inner-border"><img src="{%=o.data[i].thumb_url%}" 
                        data="{%=o.data[i].media_id%}|{%=o.data[i].display_filename%}" 
                        alt="{%=o.data[i].display_filename%}" ></div>
                    <span class="thumb-checkbox"><i class="fa fa-check fa-lg"></i></span>
                    <div class="thumb-desc">{%=o.data[i].display_filename%}</div>
                </div>
            </li>
        {% } %}
        </ul>
    </div>
    <div id="media-list-tail">
        <button id="btn-insert"><?=Yii::t('app', 'Media Attachment')?></button>
    </div>
</div>
</script>