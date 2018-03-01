/*
 * JQuery MediaAttachment 2.0.0
 * Written By Sangbom, Suhk
 * Written Date 2018. 2. 20
 * LICENSE :
 Copyright (C) 2018 Sangbom, Suhk

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE

 */
(function ($, exports) {
        var $w = $(window), $d = $(document), ww = $w.width(), wh = $w.height();

        var createMediaOverlayer = function () {
                var overlayer = document.createElement("div");
                overlayer.id = "jq_overlay";
                document.body.appendChild(overlayer);
                overlayer.onclick = hideLightbox;
                return $("#jq_overlay");
        };

        var createMediaListContainer = function () {
                var mediaListContainer = document.createElement("div"), menubar = document.createElement("div"), mediaList = document.createElement("div"), closeButton = document.createElement("img");
                mediaListContainer.id = "jq_view";
                menubar.id = "jq_menubar";
                closeButton.id = "jq_close";
                mediaList.id = "jq_content";
                closeButton.src = exports.imgUrl + "/images/common/close.png";
                closeButton.width = "20";
                closeButton.height = "20";

                menubar.appendChild( closeButton );
                mediaListContainer.appendChild( menubar );
                mediaListContainer.appendChild( mediaList );
                document.body.appendChild( mediaListContainer );
                
                closeButton.onclick = hideLightbox;
                window.onresize = window.onscroll = adjust;

                return $("#jq_view");
        };
    
        var adjust = function () {
                var $view = $("#jq_view"), w = $view.width(), h = $view.height(), ww2 = $(window).width(), wh2 = $(window).height();
                var t = $d.scrollTop() + wh2 / 2 - h / 2;
                var l = $d.scrollLeft() + ww2 / 2 - w / 2;

                if ( typeof $view == "undefined" ) return;
                if ( t < 0 ) t = 0;
                if ( l < 0 ) l = 0;

                $view.css("top", t + "px");
                $view.css("left", l + "px");

                $("#jq_overlay").width(ww + "px");
        };        
        
        var showMediaOverlayer = function (obj) {
                var de = document.documentElement;
                var st = $d.height() || document.body.scrollTop || wh();
                var sl = de.scrollLeft || document.body.scrollLeft || ww;

                obj.css("height", st + "px");
                obj.css("width", sl + "px");
                obj.show();                
        };
        
        var showMediaListContainer = function (obj) {
                obj.show();
        };
        
        var hideMediaListContainer = function (obj) {
                obj.hide();
        };
        
        var hideMediaOverlayer = function (obj) {
                obj.hide();
        };
        
        var getMediaList = function (opts) {
                var $mediaList = $( "#jq_content" ), cpage = 2, pages = 0, loading = false;
                var options = {
                        url: opts.url,
                        type: "GET",
                        data: {
                                type: opts.type,
                                mstx: $( "#mstx" ).val()
                        },
                        dataType: "json",
                        async: false,
                        cache: false,
                        success: function(result, textStatus, jqXHR) {
                                if( jqXHR.getResponseHeader( 'X-Status' ) == 'success' ) alert(result);
                                else {
                                        //console.dir(result.data.length);
                                        pages = result.pages;

                                        $mediaList.html( tmpl( "template-media-wrapper", result ) );

                                        $( "#media-types" ).change( function(){
                                                lightbox( {
                                                        url: opts.url,
                                                        width: opts.width,
                                                        height: opts.height,
                                                        type: $( this ).val(),
                                                        mstx: $( "#mstx" ).val()
                                                } );
                                        } );
                                        
                                        $( "#btn-mediasearch" ).click( function(){
                                                lightbox( {
                                                        url: opts.url,
                                                        width: opts.width,
                                                        height: opts.height,
                                                        type: $( "#media-types" ).val(),
                                                        mstx: $( "#mstx" ).val()
                                                } );
                                        } );

                                        $( "#media-list-content ul li .thumb-outer-frame" ).delegate(".thumb-inner-frame", "click", function(e){
                                                e.stopPropagation();
                                                if ( $( this ).hasClass( "tf-inner-border" ) ) {
                                                        $( this ).addClass( "tf-inner-border2" ).removeClass( "tf-inner-border" );
                                                        $( this ).parent().addClass( "tf-outer-border2" ).removeClass( "tf-outer-border" );
                                                        $( this ).next().show();
                                                } else {
                                                        $( this ).addClass( "tf-inner-border" ).removeClass( "tf-inner-border2" );
                                                        $( this ).parent().addClass( "tf-outer-border" ).removeClass( "tf-outer-border2" );
                                                        $( this ).next().hide();
                                                }
                                        } );

                                        $( "#media-list-tail" ).delegate("#btn-insert", "click", function(e){
                                                e.stopPropagation();
                                                var thumbs = $( "#media-list-content ul li .thumb-outer-frame .thumb-checkbox" ).filter( ":visible" );
                                                var va = '', lis = '', tVa, splitedVa;
                                                for ( var i=0, l=thumbs.length; i<l; i++) {
                                                        tVa = thumbs.eq(i).parent().find( 'img' ).attr( 'data' );
                                                        splitedVa = tVa.split( "|" );
                                                        lis += "<li><span class=\"af-item\">"
                                                                + splitedVa[1] 
                                                                + "</span><img class=\"afi-delete\" src=\"/images/common/delete.png\"><input type=\"hidden\" name=\"attachment[]\" value=\"" 
                                                                + tVa 
                                                                + "\" /></li>";
                                                        if ( !va ) {
                                                                va = tVa;
                                                        }
                                                        else { 
                                                                va += '#' + tVa;
                                                        }
                                                }

                                                $( '#attached-files' ).html( lis ).show();
                                                $( "#attached-files li .afi-delete").click( function(e){
                                                        e.stopPropagation();
                                                        $( this ).parent().remove();
                                                } );
                                                hideMediaOverlay();
                                        } );

                                        $( "#media-list-content" ).delegate(".thumb-outer-frame", "mouseenter", function(e) {                        
                                                e.stopPropagation();
                                                $( this ).find( '.thumb-desc' ).css({'display':'table'});
                                        } );

                                        $( "#media-list-content" ).delegate(".thumb-outer-frame", "mouseleave", function(e) {                        
                                                e.stopPropagation();
                                                $( this ).find( ".thumb-desc" ).hide();
                                        } );

                                        $( "#jq_vw_content #media-wrapper").delegate("#media-list-content", "scroll", function() {
                                                if ( !loading && cpage >= 2 && cpage <= pages && ( $mediaList.prop('scrollHeight') - $mediaList.height() - $mediaList.scrollTop() < $mediaList.height() ) ) {
                                                        loading = true;
                                                        var options2 = {
                                                                url: opts.url,
                                                                type: "GET",
                                                                data: { 
                                                                        cpage: cpage,
                                                                        type: $( "#media-types" ).val(),
                                                                        mstx: $( "#mstx" ).val(),
                                                                },
                                                                dataType: "json",
                                                                async: false,
                                                                cache: false,
                                                                success: function(result, textStatus, jqXHR) {
                                                                        if(jqXHR.getResponseHeader('X-Status') == 'success') alert(result);
                                                                        else {
                                                                                $( "#media-list" ).append( tmpl( "template-media-list", result ) );
                                                                        }
                                                                },
                                                                complete: function() {
                                                                        loading = false;
                                                                        cpage += 1;
                                                                }
                                                        };
                                                        $.ajax(options2);
                                                }
                                        }); 
                                        return false;
                                }
                        }
                };

                $.ajax(options);                 
        }; 
        
        var emptyMediaList = function () {
                $("#jq_content").empty();
        };    

        exports.showLightbox = function() {
                var overlayer = $("#jq_overlay"), mediaListContainer = $("#jq_view");
                if ( !overlayer.length ) {
                        overlayer = createMediaOverlayer();
                        showMediaOverlayer(overlayer);
                }
                else {
                        showMediaOverlayer(overlayer);
                }
                if ( !mediaListContainer.length ) {
                        mediaListContainer = createMediaListContainer();
                        showMediaListContainer(mediaListContainer);
                }
                else {
                        showMediaListContainer(mediaListContainer);
                }
        };
        
        var hideLightbox = function() {
                var overlayer = $("#jq_overlay"), mediaListContainer = $("#jq_view");
                
                emptyMediaList();
                if ( mediaListContainer.length ) {
                        hideMediaListContainer(mediaListContainer);
                }
                if ( overlayer.length ) {
                        hideMediaOverlayer(overlayer);
                }
        };
    
        exports.lightbox = function(opts) {
                getMediaList(opts);
                $(window).trigger("scroll");
        };
})(jQuery, window);