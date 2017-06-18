angular.element(document).ready(function() {

    // 引入jQuery
    app.factory('jQuery', [
        '$window',
        function ($window) {
            return $window.jQuery;
        }
    ]);
    // ng-repeat finished 指令
    app.directive('onFinishRender', function ($timeout) {
        return {
            restrict: 'A',
            link: function (scope, element, attr) {
                if (scope.$last === true) {
                    $timeout(function () {
                        scope.$emit(attr.onFinishRender);
                    });
                }
            }
        }
    });
    // 排序指令
    app.directive('sortOrderDirective', function (jQuery) {
        return {
            restrict: 'A',
            replace : true,
            scope: {
                title:'@',
                sortParams:'=',
                getData:'&getFunc',
            },
            template: '<th class="sort-th {{ classStr }}" ng-click="sortOrder()"><a href="javascript:void(0)">{{ title }}</a></th>',
            link: function (scope, element, attr) {
                scope.sortType = '';
                scope.classStr = 'sorting';
                scope.sortOrder = function(){
                    jQuery('.dataTable>thead>tr>.sort-th')
                        .removeClass('sorting_desc')
                        .removeClass('sorting_asc')
                        .addClass('sorting');
                    if (scope.sortType == 'ASC') {
                        scope.sortType = 'DESC';
                        scope.classStr = 'sorting_desc';
                    } else {
                        scope.sortType = 'ASC';
                        scope.classStr = 'sorting_asc';
                    }
                    scope.sortParams = {sortType : scope.sortType, sortColumn: attr.sortColumn};
                    scope.getData({sortParams: scope.sortParams});
                }
            }
        }
    });
    //双日历
    app.constant('dateRangePickerOptions', {
        autoUpdateInput: false,
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        timePickerSeconds: true,
        locale: {
            format: 'YYYY-MM-DD HH:mm:ss',
            applyLabel: '确定',
            cancelLabel: '清除',
            customRangeLabel: 'Custom',
            daysOfWeek: ['日', '一', '二', '三', '四', '五', '六'],
            monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
            opens: 'left',
            firstDay: 1,
        },
    });
    //单日历
    app.constant('singleDateRangePickerOptions', {
        autoUpdateInput: false,
        timePicker: true,
        timePicker24Hour: true,
        timePickerIncrement: 1,
        timePickerSeconds: true,
        singleDatePicker: true,
        locale: {
            format: 'YYYY-MM-DD HH:mm:ss',
            applyLabel: '确定',
            cancelLabel: '清除',
            customRangeLabel: 'Custom',
            daysOfWeek: ['日', '一', '二', '三', '四', '五', '六'],
            monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
            opens: 'left',
            firstDay: 1,
        },
    });
});
