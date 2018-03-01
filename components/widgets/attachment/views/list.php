<!-- The template to display thumbnail image -->
<script id="template-media-list" type="text/x-tmpl">
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
</script>
