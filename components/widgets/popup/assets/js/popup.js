/*
 * Popup script 1.0
 * Written By Sangbom, Suhk
 * Written Date 2017. 11. 30
 * Modified Date 2017. 12. 04
 * LICENSE :
 Copyright (C) 2017 Sangbom, Suhk

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE

 */
(function ($) {
        $("#block-popup").on("click", function(e){
                e.stopPropagation();
                var csrfToken = $("meta[name='csrf-token']").attr("content"),  popupid = $("#popupid").val();
                //console.log(csrfToken + '-' + popupid);
                var options = {
                        url: '/popup/cookie',
                        type : 'POST',
                        dataType : 'json',
                        data : {
                            _csrf : csrfToken,
                            popupid : popupid,
                        },
                        async: false,
                        cache: false,
                        success : function(result, textStatus, jqXHR){
                                //alert(result);
                                if (result.message == 'success') {
                                        $("#block-popup").parent().parent().hide();
                                        return false;
                                }                               
                        }
                };
                $.ajax(options);
                
        });
        $("#btn-pclose").on("click", function(e){
                e.stopPropagation();
                $(this).parent().parent().hide();
        });
})(jQuery);