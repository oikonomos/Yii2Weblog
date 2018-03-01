/*
 * JQuery MediaAttachment 1.0
 * Written By Sangbom, Suhk
 * Written Date 2017. 5. 5
 * LICENSE :
 Copyright (C) 2014 Sangbom, Suhk

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE

 */
(function ($, exports) {
    var $w = $(window), $d = $(document), ww = $w.width(), wh = $w.height();
    
    var jq_adjust = function () {
        var $view = $("#jq_view"), w = $view.width(), h = $view.height();
        var t = $d.scrollTop() + wh / 2 - h / 2;
        var l = $d.scrollLeft() + ww / 2 - w / 2;

        if ( typeof $view == "undefined" ) return;
        if ( t < 0 ) t = 0;
        if ( l < 0 ) l = 0;

        $view.css("top", t + "px");
        $view.css("left", l + "px");

        $("#jq_overlay").width(ww + "px");
    }
    
    var jq_createOverlay = function() {
        var jq_overlay = document.createElement("div");
        jq_overlay.id = "jq_overlay";

        jq_overlay.onclick = jq_hideOverlay;
        document.body.appendChild( jq_overlay );

        return jq_overlay;
    };
    
    var jq_hideOverlay = function() {
        $("#jq_overlay").hide();
        $("#jq_content").empty();
        $("#jq_view").hide(); 
    };
    
    var jq_showOverlay = function() {
        var overlay = $("#jq_overlay");
        var de = document.documentElement;

        var st = $d.height() || document.body.scrollTop || wh;
        var sl = de.scrollLeft || document.body.scrollLeft || ww;
        
        overlay.css("height", st + "px");
        overlay.css("width", sl + "px");

        overlay.show();
    };

    var jq_createViewContainer = function() {
        var vw_container = document.createElement("div");
        var vw_menubar = document.createElement("div");
        var vw_content = document.createElement("div");
        var jq_vw_close = document.createElement("img");
        vw_container.id = "jq_view";
        vw_menubar.id = "jq_menubar";
        jq_vw_close.id = "jq_close";
        vw_content.id = "jq_content";
        jq_vw_close.src = exports.imgUrl + "/images/common/close.png";
        jq_vw_close.width = "30";
        jq_vw_close.height = "30";

        vw_menubar.appendChild( jq_vw_close );
        vw_container.appendChild( vw_menubar );
        vw_container.appendChild( vw_content );
        document.body.appendChild( vw_container );
        window.onresize = window.onscroll = jq_adjust;

        return vw_container;
    };

    var jq_show = function() {
        $("#jq_view").slideDown(400, function(){
            jq_adjust();				
        });
    }

    exports.jq_readyLightbox = function() {
            var ol, iVC;

            if ( !$("#jq_overlay").length ) ol = jq_createOverlay();

            if ( !$("#jq_view").length ) {
                    iVC = jq_createViewContainer();
            }

            jq_showOverlay();
    };
    
    exports.jq_lightbox = function(opts) {
        var $iVC = $( "#jq_content" ),
            cpage = 2,
            pages = 0,
            loading = false;

        var options = {
                url: opts.url,
                type: "GET",
                data: {
                    "type": opts.type
                },
                dataType: "json",
                async: false,
                cache: false,
                success: function(result, textStatus, jqXHR) {
                    if( jqXHR.getResponseHeader( 'X-Status' ) == 'success' ) alert(result);
                    else {
                        pages = result.pages;

                        $iVC.html( tmpl( "template-media-wrapper", result ) );
                        jq_show($iVC);

                        $( "#jq_menubar>img" ).click( function(e){
                            e.stopPropagation();
                            jq_hideOverlay();
                        } );

                        $( "#media-types" ).change( function(){
                            jq_lightbox( {
                                url: opts.url,
                                width: opts.width,
                                height: opts.height,
                                type: $( this ).val()
                            } );
                        } );
                        
                        $( "#media-list-content ul li .thumb-outer-frame" ).delegate(".thumb-inner-frame", "click", function(e){
                            e.stopPropagation();
                            if ( $( this ).hasClass( "tf-inner-border" ) ) {
                                $( this ).addClass( "tf-inner-border2" ).removeClass( "tf-inner-border" );
                                $( this ).parent().addClass( "tf-outer-border2" ).removeClass( "tf-outer-border" );
                                $( this ).next().show(200);
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
                                        + "</span><img class=\"afi-delete\" src=\""
                                        + exports.imgUrl
                                        + "/images/common/delete.png\"><input type=\"hidden\" name=\"attachment[]\" value=\"" 
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
                            jq_hideOverlay();
                        } );

                        $( "#media-list-content" ).delegate(".thumb-outer-frame", "mouseenter", function(e) {                        
                                e.stopPropagation();
                                $( this ).find( '.thumb-desc' ).css({'display':'table'});
                        } );

                        $( "#media-list-content" ).delegate(".thumb-outer-frame", "mouseleave", function(e) {                        
                                e.stopPropagation();
                                $( this ).find( ".thumb-desc" ).hide();
                        } );
                        
                        $( "#jq_content #media-wrapper").delegate("#media-list-content", "scroll", function(){
                            if ( !loading && cpage >= 2 && cpage <= pages && ( $iVC.prop('scrollHeight') - $iVC.height() - $iVC.scrollTop() < $iVC.height() ) ) {
                                loading = true;
                                var options2 = {
                                    url: opts.url,
                                    type: "GET",
                                    data: { 
                                        "cpage": cpage,
                                        "type": $( "#media-types" ).val()                         
                                    },
                                    dataType: "json",
                                    async: false,
                                    cache: false,
                                    success: function(result, textStatus, jqXHR) {
                                        if(jqXHR.getResponseHeader('X-Status') == 'success') alert(result);
                                        else {
                                            $( "#media-list" ).append( tmpl( "template-media-list", result ) );

                                            /*$( "#media-list-content ul li .thumb-outer-frame .thumb-inner-frame" ).off( "click" );        
                                            $( "#media-list-content ul li .thumb-outer-frame .thumb-inner-frame" ).click(  function(e){
                                                e.stopPropagation();
                                                if ( $( this ).hasClass( "tf-inner-border" ) ) {
                                                    $( this ).addClass( "tf-inner-border2" ).removeClass( "tf-inner-border" );
                                                    $( this ).parent().addClass( "tf-outer-border2" ).removeClass( "tf-outer-border" );
                                                    $( this ).next().show(200);
                                                } else {
                                                    $( this ).addClass( "tf-inner-border" ).removeClass( "tf-inner-border2" );
                                                    $( this ).parent().addClass( "tf-outer-border" ).removeClass( "tf-outer-border2" );
                                                    $( this ).next().hide();
                                                }
                                            } );*/

                                            /*$( "#media-list-content .thumb-outer-frame" ).mouseenter( function(e) {                        
                                                    e.stopPropagation();
                                                    $( this ).find( ".thumb-desc" ).show();
                                            } );

                                            $( "#media-list-content .thumb-outer-frame" ).mouseleave( function(e) {                        
                                                    e.stopPropagation();
                                                    $( this ).find( ".thumb-desc" ).hide();
                                            } );*/
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
})(jQuery, window);