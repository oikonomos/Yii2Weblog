/**
 * admin.js
 * @Author Sangbom, Suhk
 * @date 2018. 08. 16
 */
$(document).ready(function () {

        /**
         * admin navigation
         */
        var $greetingLink = $("#ab-greeting"), $profileWrap = $("#ab-profilewrap"), $adminbarSecondaryLi = $("#ab-secondary > li"), $gsearchBtn = $("#btn-search"), $gsearchWrap = $("#ab-searchwrap");
        
        $greetingLink.on( 'mouseenter', function (e) {
                e.stopPropagation();
                $profileWrap.show();
        } );
        
        $profileWrap.on( 'mouseleave', function (e) {
                e.stopPropagation();
                $(this).hide();
        } );
        
        $adminbarSecondaryLi.eq(0).on( 'mouseleave', function (e) {
                e.stopPropagation();
                $profileWrap.hide();
        } );
        
        $gsearchBtn.on( 'click', function (e) {
                e.stopPropagation();
                var $child = $gsearchWrap.find("input[type='text']");
                if ( $child.css('display') != 'none' ) {
                        $child.animate( { width : '0', display : 'none' }, 400, function () { $(this).hide(); } );
                }
                else {
                        $child.css({ display : 'block' }).animate( { width : '200px' }, 400 );
                }
        } );
        
        $gsearchWrap.find("button").on("focus", function (e) {
                e.stopPropagation();
                $(this).blur();
        });
        
        $gsearchWrap.find("input[type='text']").on("focusout", function (e) {
                e.stopPropagation();
                $(this).hide();
        });
});

