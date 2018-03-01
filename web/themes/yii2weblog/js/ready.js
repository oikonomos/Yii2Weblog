/**
 * 버전 : 1.0.0
 * 만든 이 : 석상범
 * 만든 일자 : 2015. 9. 23
 * 슬라이더들 구동 및 GNB 관련 스크립트 모음. 
 * LICENSE :
 Copyright (C) 2015 Sangbom, Suhk

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE

 **/
$(document).ready(function(){
        /* 슬라이더 구동 */
        var resolution = 1170 / 878, maxWidth = 1170, curWidth = $("#mainslider-wrap").width();
        if (curWidth > maxWidth) {
                curWidth = 1170;
        }
        
        var sliderFrame = $("#mainslide-frame");
        sliderFrame.height(curWidth / resolution);
        var ms = new MySlider({
                sliderFrame: "mainslide-frame",
                slideHolder: "mainslide-holder",
                slide: "mainslide",
                buttonHolder: "button-wrap",
                speed: 1E3,
                slidingPlane: "horizontal",
                period:8E3,
                direction:"left",
                isNaviArrow: false,
                maxWidth: maxWidth,
                resolution: resolution,
                leftArrow: "left-arrow",
                rightArrow: "right-arrow"
        });
});