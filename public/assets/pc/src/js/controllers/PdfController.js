/**
 * pdf转图片
 * @author jason <numberjason@gamil.com>
 * @since 2017-06-05
 */
(function() {
    var Controller = {};
    /**
     * pdf转图片
     */
    PdfToImg.$inject = ['$scope', '$rootScope', '$location', '$route', 'jQuery', '$http'];
    function PdfToImg($scope, $rootScope, $location, $route, $, $http) {
        $rootScope.title = 'pdf转图片';
        $rootScope.baseUrl = baseUrl;
        //已完成
        $scope.showSuccess = function() {
            var toast = $('.js-show-success');
            if (toast.css('display') != 'none') {
                return;
            }
            toast.fadeIn(100);
            setTimeout(function () {
                toast.fadeOut(100);
            }, 2000);
        }
        //加载中
        $scope.showLoadingToast = function() {
            console.log('fuck');
            var loadingToast = $('.js-show-loading');
            if (loadingToast.css('display') != 'none') {
                return;
            }
            loadingToast.fadeIn(100);
            // setTimeout(function () {
            //     loadingToast.fadeOut(100);
            // }, 2000);
        }
        //预览pdf
        $scope.showLoadingPic = function() {
            let data = {
                type: 'num'
            }
            let loadingToast = $('.js-show-loading');
            $.ajax({
                url: baseUrl + 'api/pdf/to/img',
                type: 'post',
                dataType: 'json',
                data: data,
                beforeSend: function() {
                    if (loadingToast.css('display') != 'none') {
                        return;
                    }
                    loadingToast.fadeIn(100);
                },
                success: function(resp) {
                    for (let i = 1; i <= resp.data.num; i++) {
                        let item = '';
                        item += "<li class='weui-uploader__file js_"+i+"_img' style='background-image:url(/assets/pc/src/imgs/loading.gif)'></li>"
                        $('.imgs-parent').append(item);
                        $scope.showRaelPic(i);
                    }
                },
            });
        }
        //显示真正图片
        $scope.showRaelPic = function(num) {
            let data = {
                type: 'img',
                pic_no: num
            }
            let loadingToast = $('.js-show-loading');
            $.ajax({
                url: baseUrl + 'api/pdf/to/img',
                type: 'post',
                dataType: 'json',
                data: data,
                success: function(resp) {
                    if (num == 1) {
                        loadingToast.fadeOut(100);
                    }
                    $(".js_"+num+"_img").css("background-image", "url("+resp.data.realPath+")");
                },
            });
        }


        //预览pdf
        // $scope.showPic = function() {
        //     let data = {
        //         status: '1'
        //     }
        //     let toast = $('.js-show-success');
        //     let loadingToast = $('.js-show-loading');
        //     $.ajax({
        //         url: baseUrl + 'api/pdf/to/img',
        //         type: 'post',
        //         dataType: 'json',
        //         data: data,
        //         beforeSend: function() {
        //             if (loadingToast.css('display') != 'none') {
        //                 return;
        //             }
        //             loadingToast.fadeIn(100);
        //         },
        //         success: function(resp) {
        //             loadingToast.fadeOut(100);
        //             toast.fadeIn(100);
        //             setTimeout(function () {
        //                 toast.fadeOut(100);
        //             }, 2000);
        //             console.log(resp);
        //         },
        //     });
        // }
    }
    Controller['PdfToImg'] = PdfToImg;
    ngControllerInit('PdfController', Controller);
})();
