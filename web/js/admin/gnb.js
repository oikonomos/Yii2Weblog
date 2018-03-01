/**
 * primary menu
 * Author : Sangbom, Suhk 
 */
/**
 * primary menu
 * Author : Sangbom, Suhk 
 */
;(function (factory) {
        'use strict';
        if (typeof define === 'function' && define.amd) {
                define(['jquery'], factory);
        } else if (typeof exports === 'object') {
                module.exports = factory(require('jquery'));
        } else {
                factory(jQuery);
        }
} (function ($) {
        'use strict';
        var $sidenavwrap = $("#sidebar-navwrap"), $sidenav = $("#sidebar-nav"), $li = $("#sidebar-nav > li"), $navItem = $("#sidebar-nav > li > a"), 
             $subnav = $("#sidebar-nav > li > ul"), $collapseBtn=$("#sidebar-nav > li.collapse-menu > a"), $mobilemenuBtn = $("#ab-default > li > a.btn-mobilemenu"),
             length = $navItem.length, nav = [], niWidth = $navItem.width(), extractedniWidth = 40, normalniWidth=160;
        
        var N = function (n) {
                this.n = n;
                this.p = $navItem.eq(n);
                this.subnav = this.p.parent().find("ul");
                this.isSubnav = (this.subnav.length) ? true : false;
                this.isHidden = (this.subnav.css("display") == 'none') ? true : false;
                this.isActive = (this.p.parent().hasClass('active')) ? true: false;
                this.isCollapsemenu = (this.p.parent().hasClass('collapse-menu')) ? true: false;
                this.url = this.p.attr("href");
        };
        
        N.prototype.showSubnav = function () {
                this.subnav.css({position : 'absolute', top : 0, left : niWidth+'px'}).show();
                this.isHidden = false;
        };
        
        N.prototype.restoreSubnav = function () {
                this.subnav.css({position : 'relative', top : 0, left : 0}).hide();
                this.isHidden = true;
        };
        
        N.prototype.openSubnav = function () {
                this.subnav.show();
                this.isHidden = false;
        };
        
        N.prototype.closeSubnav = function () {
                this.subnav.hide();
                this.isHidden = true;
        };
        
        var restoreSNs = function (idx) {
                for ( var i = 0; i < length; i++ ) {
                        if ( !nav[i].isActive  &&  !nav[i].isCollapsemenu ) {
                                if ( idx != i ) {
                                        nav[i].p.removeClass('nav-over');
                                }
                                if (nav[i].isSubnav) {
                                        nav[i].restoreSubnav();
                                }
                        }
                }
        };
        
        var closeSNs = function () {
                for ( var i = 0; i < length; i++ ) {
                        if ( nav[i].isSubnav ) {
                                nav[i].subnav.hide();
                        }
                }
        };
        
        var preventLinkEvent = function () {
                for ( var i = 0; i < length; i++ ) {
                        if (nav[i].isSubnav)
                                $navItem.eq(i).attr('href', 'javascript:void(0);');
                }
        };
        
        var restoreUrl = function () {
                for ( var i = 0; i < length; i++ ) {
                        if (nav[i].isSubnav)
                                $navItem.eq(i).attr('href', nav[i].url);
                }
        };
        
        var init = function () {
                for ( var i = 0; i < length; i++ ) {
                        nav.push(new N(i));
                }
        };
        
        var run = function () {
                init();
                
                $(window).on("resize", function (e) {
                        e.stopPropagation();
                        var ww = $(this).width();
                        if ( ww > 768 ) {
                                $sidenavwrap.css({position : 'fixed', display : 'block', height : '100%'});
                                restoreUrl();
                                niWidth = $navItem.width();
                                $collapseBtn.show();
                                $mobilemenuBtn.hide();
                                $navItem.off();
                                $navItem.on('mouseenter', function (e) {
                                        e.stopPropagation();
                                        var i = $navItem.index($(this));
                                        restoreSNs(i);
                                        if ( !nav[i].isActive  &&  !nav[i].isCollapsemenu ) {
                                                if ( !$(this).parent().hasClass("active") )
                                                        nav[i].p.addClass('nav-over');
                                                if (nav[i].isSubnav) {
                                                        nav[i].showSubnav();
                                                }
                                        } 
                                });

                                $navItem.on('mouseleave', function (e) {
                                        e.stopPropagation();
                                        var i = $navItem.index($(this));
                                        if ( !nav[i].isActive  &&  !nav[i].isCollapsemenu ) {
                                                if (!nav[i].isSubnav) {
                                                        nav[i].p.removeClass('nav-over');
                                                }
                                        } 
                                });

                                $subnav.on('mouseleave', function (e) {
                                        e.stopPropagation();
                                        restoreSNs(-1);
                                });

                                $collapseBtn.on("click", function (e) {
                                        e.stopPropagation();
                                        var $i = $(this).find("i");
                                        if ( $i.hasClass("fa-arrow-left") ) {
                                                $(".sb-navwrap, .sb-navwrap > ul").width(extractedniWidth);
                                                niWidth = $navItem.width();
                                                $navItem.find(".sb-menu-label").hide();
                                                var $activeLi = $sidenav.find(">.active");
                                                var idx = $li.index($activeLi);
                                                nav[idx].isActive = false;
                                                $activeLi.find("ul").hide();
                                                $(this).find("i").removeClass("fa-arrow-left").addClass("fa-arrow-right");
                                        }
                                        else {
                                                $(".sb-navwrap, .sb-navwrap > ul").width(normalniWidth);
                                                niWidth = $navItem.width();
                                                $navItem.find(".sb-menu-label").show();
                                                var $activeLi = $sidenav.find(">.active");
                                                var idx = $li.index($activeLi);
                                                nav[idx].isActive = true;
                                                $activeLi.find("ul").show();
                                                $(this).find("i").removeClass("fa-arrow-right").addClass("fa-arrow-left");
                                        }
                                });
                        }
                        else {
                                var dh = $(document).height();
                                $sidenavwrap.css({position : 'absolute', display : 'none', height : dh + 'px'});
                                preventLinkEvent();
                                $collapseBtn.hide();
                                $mobilemenuBtn.show();
                                $navItem.off();
                                $subnav.off();
                                $(".sb-navwrap, .sb-navwrap > ul").width(normalniWidth);
                                niWidth = $navItem.width();
                                $navItem.find(".sb-menu-label").show();
                                var $activeLi = $sidenav.find(">.active");
                                var idx = $li.index($activeLi);
                                nav[idx].isActive = true;
                                $activeLi.find("ul").show();
                                $(this).find("i").removeClass("fa-arrow-right").addClass("fa-arrow-left");
                                $navItem.on('click', function (e) {
                                        e.stopPropagation();
                                        var i = $navItem.index($(this));
                                        closeSNs();
                                        if (nav[i].isSubnav) {
                                                nav[i].openSubnav();
                                        }
                                        else {
                                                nav[i].closeSubnav();
                                        }
                                });
                        }
                });
                
                $mobilemenuBtn.on( "click", function (e) {
                        e.stopPropagation();
                        if ( $sidenavwrap.css("display") != 'none' ) {
                                $sidenavwrap.hide();
                        }
                        else {
                                $sidenavwrap.show();
                        }
                } );
                
                $(window).trigger("resize");
        }; 
        
        run();
}));

