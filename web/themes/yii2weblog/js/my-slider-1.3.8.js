/**
 * 버전 : 1.3.1
 * 만든 이 : 석상범
 * 작성일 : 2014. 8. 5
 * 수정일 : 2015년 9월 25일
 * 슬라이드의 높이 고정하고 해상도는 사용하지 않음.
 Copyright (C) 2014 Sangbom, Suhk

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE

 * params : opts(JSON)
 * slideHolder: Slide Holder ID
 * Slide : Slide Classname
 * buttonHolder: Button Holder ID
 * speed
 * slidingPlane: horizontal or vertical),
 * period: Timer Duration
 * direction: left or right or up or down
 * isNaviArrow: 좌우 또는 상하 화살표 내비게이션 보이기(true or false)
 * 이전 버전
 * 1.0.0 : 슬라이드와 내비게이션 버튼를 가르키는 포인터 객체를 생성하여 이미지 슬라이드를 구현한다.
 * 1.1.0 : 수평면 슬라이딩과 수직면 슬라이딩을 합침.
 * 1.1.1 : 슬라이딩 입력 변수들을 JSON으로 바꿈.
 * 1.3.1 : resizeFrame 수정
 * 1.3.8 : 애니메이션 방식을 변경
 **/
var MySlider = function(opts){
        var sliderFrame = $("#"+opts.sliderFrame),
                slideHolder = $("#"+opts.slideHolder),
                slide=$("#"+opts.slideHolder+">."+opts.slide),
                btnHolder=$("#"+opts.sliderFrame+" #"+opts.buttonHolder),
                btn=$("#"+opts.sliderFrame+" #"+opts.buttonHolder+">img"),
                w = slide.eq(0).width(),
                h = slide.eq(0).height(),
                slides=[],
                btns=[],
                len=slide.length,
                tid=null,
                cnt=0,
                isAni=false,
                clickedIdx=-1;

        /* 좌우측 화살표 내비게이션을 활성활 경우 */
        if (opts.isNaviArrow) {
                var firstArrow = $("#"+opts.sliderFrame+" #first-arrow").show(),
                        secondArrow = $("#"+opts.sliderFrame+" #second-arrow").show();
        }

        /* 윈도우 resise event가 발생할 때 */
        var resizeFrame = function(nw, nh) {
                sliderFrame.height( nh );
                for (var i=0; i<len; i++) {
                        slides[i].p.css( { 'width' : nw, 'height' : nh } );
                        slides[i].w = nw;
                        slides[i].h = nh;
                        slides[i].distance = ("horizontal"==opts.slidingPlane)?nw:nh;			
                }
        };

        /* 이미지 슬라이드를 지시하는 포인터 객체 정의 */
        PS=function(a,b,c,d,e){
                this.p=slide.eq(a);
                this.n=a;
                this.w=b;
                this.h=c;
                this.to = 0;
                this.from = 0;
                this.distance = ("horizontal"==opts.slidingPlane)?b:c;
                this.direction="";
                this.isMoving=false;
        };

        /* 객체에 move 메소드를 추가시킴 */
        PS.prototype.move=function(a,b){
                zi = (0 == b) ? "10" : "0";
                /* 좌우 슬라이딩일 경우 */
                if ("horizontal"==opts.slidingPlane) {
                        this.w = slide.eq(0).width();
                        this.h = slide.eq(0).height();
                        sliderFrame.height(this.h);                        
                        /* 좌우로 슬라이딩한다. */
                        this.p.css({display:"block",zIndex:zi}).fadeOut(opts.speed,function(){
                                if (0==b) {
                                        $(this).css({display:"none",left:"0",top:"0px"});
                                }
                                isAni = false;
                                this.w = slide.eq(0).width();
                                this.h = slide.eq(0).height();
                                sliderFrame.height(this.h);
                        });
                }
                /* 상하 슬라이딩일 경우 */
                else {
                        this.w = slide.eq(0).width();
                        this.h = slide.eq(0).height();
                        sliderFrame.height(this.h);
                        /* 위아래로 슬라이딩한다. */
                        this.p.css({display:"block",zIndex:zi}).fadeOut(opts.speed,function(){
                                if (0==b) {
                                        $(this).css({display:"none",top:"0",top:"0px"});
                                }
                                isAni = false;
                                this.w = slide.eq(0).width();
                                this.h = slide.eq(0).height();
                                sliderFrame.height(this.h);
                        });
                }
        }

        /* 네비게이션 버튼 포인팅 객체 생성 */
        var NB=function(a,b){
                this.p = btn.eq(a);
                this.n=a;
                this.imgSrc=b;
        };

        /* 
         * 내비게이션 객체에 chane 메소드 추가
         * 임의의 내비게이션 버튼이 선택되었을 대, on 상태로 되어 있는 모든 이미지를 off 상태의 이미지로 바꾸고,
         * 선택된 버튼의 off 상태를 on 상태를 표시하는 이미지로 바꾼다. 
         */
        NB.prototype.change=function(){
                var s, ns;
                for(var i=0; i<len;i++) {
                        s = btn.eq(i).attr("src");
                        ns = s.replace("_on","_off");
                        if (i != this.n && s != ns) {
                                btn.eq(i).attr("src", ns);
                        }
                }

                ns = this.imgSrc.replace("_off","_on");
                this.p.attr("src",ns);
        };

        /* 자동 슬라이딩 모드일 경우, 슬라이딩을 할 다음 슬라이드의 인텍스 값을 계산하여 리턴한다. */
        var getNextCnt = function(dir) {
                /* 좌측 또는 위로 슬라이딩할 경우 */
                if("left"==dir||"up"==dir) {
                        return (cnt + 1) % len;
                }
                /* 우측 또는 아래로 슬라이딩할 경우 */
                else {
                        cnt = cnt - 1;
                        if (cnt < 0) {
                                cnt = len - 1;
                        }
                        return cnt;
                }
        };

        /* 슬라이드들과 버튼들의 객체를 생성한다. */
        var init = function(){
                for(var i=0; i<len; i++) {
                        slides.push(new PS(i, slide.eq(i).width(),slide.eq(i).height(),opts.direction,0));
                        btns.push(new NB(i, btn.eq(i).attr("src")));
                }
        };

        /* 슬라이딩 실행 함수 */
        var run = function() {
                init();

                /* 버튼 click 이벤트 붙이기 */
                btn.click(function(e){
                        e.stopPropagation();
                        var idx = btn.index($(this));
                        if (idx != clickedIdx) {
                                if (!isAni) {
                                        isAni = true;				
                                        var shownSlide = slide.filter(":visible");
                                        var curIdx = slide.index(shownSlide);
                                        clickedIdx = cnt = idx;
                                        btns[idx].change();
                                        slides[curIdx].move(opts.direction,0);
                                        slides[idx].p.css( {zIndex : '5'} ).show();
                                }
                        }
                });

                /* 버튼 mouseover 이벤트 붙이기 */
                btnHolder.mouseenter(function(e){
                        e.stopPropagation();
                        clearInterval(tid);
                });

                /* 버튼 mouseout 이벤트 붙이기 */
                btnHolder.mouseleave(function(e){
                        e.stopPropagation();
                        tid = setInterval(function(){
                                cnt = getNextCnt(opts.direction);
                                btn.eq(cnt).trigger("click")
                        },opts.period);
                });

                /* 화살표 버튼을 사용할 경우 화살표 버튼들의 활성화 및 이벤트 붙이기 */
                if (opts.isNaviArrow) {
                        /* 좌측 화살표 활성화 및 이벤트 붙이기 */
                        firstArrow.show().mouseenter(function(e){
                                e.stopPropagation();
                                clearInterval(tid);
                        });
                        firstArrow.click(function(e){
                                e.stopPropagation();
                                if (!isAni) {
                                        isAni = true;
                                        var shownSlide = slide.filter(":visible");
                                        var curIdx = slide.index(shownSlide);					
                                        if ("horizontal"==opts.slidingPlane) {
                                                var idx = getNextCnt("left");
                                                cnt = idx;
                                                btns[idx].change();
                                                slides[curIdx].move("left",0);
                                                slides[idx].p.css( {zIndex : '5'} ).show();
                                        }
                                        else {						
                                                var idx = getNextCnt("up");
                                                cnt = idx;
                                                btns[idx].change();
                                                slides[curIdx].move("up",0);
                                                slides[idx].p.css( {zIndex : '5'} ).show();
                                        }
                                }
                        });
                        firstArrow.mouseleave(function(e){
                                e.stopPropagation();
                                tid = setInterval(function(){
                                        cnt = getNextCnt();
                                        btn.eq(cnt).trigger("click");
                                },opts.period);
                        });
                        /* 우측 화살표 활성화 및 이벤트 붙이기 */
                        secondArrow.show().mouseenter(function(e){
                                e.stopPropagation();
                                clearInterval(tid);
                        });
                        secondArrow.click(function(e){
                                e.stopPropagation();
                                if (!isAni) {
                                        isAni = true;
                                        var shownSlide = slide.filter(":visible");
                                        var curIdx = slide.index(shownSlide);
                                        if ("horizontal"==opts.slidingPlane) {
                                                var idx = getNextCnt("right");
                                                cnt = idx;
                                                btns[idx].change();
                                                slides[curIdx].move("right",0);
                                                slides[idx].p.css( {zIndex : '5'} ).show();
                                        }
                                        else {
                                                var idx = getNextCnt("down");
                                                cnt = idx;
                                                btns[idx].change();
                                                slides[curIdx].move("down",0);
                                                slides[idx].p.css( {zIndex : '5'} ).show();
                                        }
                                }
                        });
                        secondArrow.mouseleave(function(e){
                                e.stopPropagation();
                                tid = setInterval(function(){
                                        cnt = getNextCnt(opts.direction);
                                        btn.eq(cnt).trigger("click");
                                },opts.period);
                        });
                    }
                    /* window resize event */
                    $( window ).resize( function(e){
                        e.stopPropagation();
                        var ww = $( window ).width();
                        if (ww > opts.maxWidth) {
                                ww = opts.maxWidth;
                        }
                        resizeFrame( ww, ww/opts.resolution );
                    } );

                /* 슬라이드 첫번째 이미지를 보임. */
                slide.eq(0).css({display:"block"});

                /* 주기적으로 슬라이등을 하기 위해서 타이머를 구동시킨다. */
                tid = setInterval(function(){
                        cnt = getNextCnt(opts.direction);
                        btn.eq(cnt).trigger("click");
                },opts.period);
        };

        /* 슬라이딩 실행 */
        run();
};

/** 
 * 사용법 
        var my-slider = new MySlider({
                sliderFrame : "container"
                slideHolder: "slider-holder",
                slide: "slide",
                buttonHolder: "btn-nav-holder",
                speed: 1E3,
                slidingPlane: "horizontal",
                period:2E3,
                direction:"left",
                isNaviArrow: true,
                maxWidth: maxWidth,
                resolution: rate
        });
 */