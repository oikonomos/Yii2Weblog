/* 
 * gnb.js
 * Author : Sangbom, Suhk
 * Written Date : 2017-11-03
 */
(function(){
        var $primaryNav = $("#primary-nav"), $primaryNavItem = $("#primary-nav>li>a"), $subNav = $("#primary-nav>li>ul"), $subNavItem = $("#primary-nav>li>ul>li>a"),
                $subNav2 = $("#primary-nav>li>ul ul"), PNs = [], SNs = [], len = $primaryNavItem.length, len2 = $primaryNavItem.length;
             
        var PN = function (n) {
                this.n = n;
                this.p = $primaryNavItem.eq(n);
                this.subnav = this.p.parent().find(">ul");
                this.isSubnav = (this.subnav.length) ? true : false;
                this.isShown = false;
                var $snli = this.subnav.find(">li");
                var height = $snli.height()*$snli.length + parseInt(this.subnav.css("padding-top")) + parseInt(this.subnav.css("padding-bottom"));
                this.subnav.css({height: height+'px'});             
        };
        
        PN.prototype.showSN = function () {
                if (this.isSubnav) {
                        this.subnav.css({display:'inline-block'});
                        this.isShown = true;
                }
        };
        
        PN.prototype.hideSN = function () {
                if ( this.isShown ) {
                        this.subnav.css({display:'none'});
                        this.isShown = false;
                }
        };
        
        PN.prototype.changeBg = function () {
                this.p.addClass("nav-over");
        };
        
        PN.prototype.restoreBg = function () {
                this.p.removeClass("nav-over");
        }; 
        
        var SN = function (n) {
                this.n = n;
                this.p = $subNavItem.eq(n);
                this.subnav = this.p.parent().find(">ul");
                this.isSubnav = (this.subnav.length) ? true : false;
                this.isShown = false;
        }
        
        SN.prototype.showSN = function () {
                if (this.isSubnav) {
                        this.subnav.show();
                        this.isShown = true;
                }
        };
        
        SN.prototype.hideSN = function () {
                if ( this.isShown ) {
                        this.subnav.hide();
                        this.isShown = false;
                }
        };    
        
        SN.prototype.changeBg = function () {
                this.p.addClass("nav-over");
        };
        
        SN.prototype.restoreBg = function () {
                this.p.removeClass("nav-over");
        };   
        
        var hideAllChildren = function () {
                for ( var i=0; i<len; i++ ) {
                        if (PNs[i].isShown) {
                                PNs[i].hideSN();
                        }
                }
        };
        
        var hideAllGrandChildren = function () {
                for ( var i=0; i<len2; i++ ) {
                        if (SNs[i].isShown) {
                                SNs[i].hideSN();
                        }
                }
        };
        
        var restoreAllBgs = function () {
                for ( var i=0; i<len; i++ ) {
                        PNs[i].restoreBg();
                }
        };
        
        var restoreAllGrandChildrenBgs = function () {
                for ( var i=0; i<len2; i++ ) {
                        SNs[i].restoreBg();
                }
        };
        
        var init = function () {
                for ( var i=0; i<len; i++ ) {
                        PNs.push( new PN(i) );
                }
                for ( var i=0; i<len2; i++ ) {
                        SNs.push( new SN(i) );
                }
        };
        
        var run = function () {
                init();
                
                $primaryNavItem.on("mouseenter", function (e) {
                        e.stopPropagation();
                        hideAllChildren();
                        var i = $primaryNavItem.index( $(this) );
                        PNs[i].showSN();
                        restoreAllBgs();
                        PNs[i].changeBg();
                }); 
                
                $subNavItem.on("mouseenter", function (e) {
                        e.stopPropagation();
                        hideAllGrandChildren();
                        var i = $subNavItem.index( $(this) );
                        SNs[i].showSN();
                        restoreAllGrandChildrenBgs();
                        SNs[i].changeBg();
                });
                
                $primaryNav.on("mouseleave", function (e) {
                        e.stopPropagation();
                        hideAllChildren();
                        hideAllGrandChildren();
                        restoreAllBgs();
                });
        };
        
        run();
})();

