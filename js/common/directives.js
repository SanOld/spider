spi.directive("passwordVerify", function() {
    return {
        require: "ngModel",
        scope: {
            passwordVerify: '='
        },
        link: function(scope, element, attrs, ctrl) {
            scope.$watch(function() {
                var combined;
                if (scope.passwordVerify || ctrl.$viewValue) {
                    combined = scope.passwordVerify + '_' + ctrl.$viewValue;
                }
                return combined;
            }, function(value) {
                if (value) {
                    ctrl.$parsers.unshift(function(viewValue) {
                        var origin = scope.passwordVerify;
                        if (origin !== viewValue) {
                            ctrl.$setValidity("passwordVerify", false);
                            return undefined;
                        } else {
                            ctrl.$setValidity("passwordVerify", true);
                            return viewValue;
                        }
                    });
                }
            });
        }
    };
});

spi.directive("spiHintMain", function() {
    return {
        restrict: 'A',
        scope: {
            title: '=',
            text: '='
        },
        template: '<div ng-if="title && text" class="hint-details alert alert-info m-0 clearfix"  ng-init="isCollapsed = 1"> <div class="heading-alert"> <strong ng-bind="title"></strong> <span ng-click="isCollapsed = !isCollapsed" class="show-link pull-right"> <span ng-show="isCollapsed">Zeigen</span> <span ng-hide="isCollapsed">Ausblenden</span> <span class="caret" ng-class="{\'open\': !isCollapsed}"></span> </span> </div> <div uib-collapse="isCollapsed"> <p ng-bind="text"></p> </div> </div>'
    };
});

spi.directive("spiHint", function() {
    return {
        restrict: 'A',
        scope: {
            text: '=',
            class: '@'
        },
        template: '<button ng-if="text" uib-popover="{{text}}" class="btn btn-question {{class}}" type="button"> <i class="fa fa-question"></i> </button>'
    };
});


spi.filter('tel', function () {
    return function (tel) {
        if (!tel) { return ''; }

        var value = tel.toString().trim().replace(/^\+/, '');

        if (value.match(/[^0-9]/)) {
            return tel;
        }

        var country, city, number;

        switch (value.length) {
            case 10: // +1PPP####### -> C (PPP) ###-####
                country = 1;
                city = value.slice(0, 3);
                number = value.slice(3);
                break;

            case 11: // +CPPP####### -> CCC (PP) ###-####
                country = value[0];
                city = value.slice(1, 4);
                number = value.slice(4);
                break;

            case 12: // +CCCPP####### -> CCC (PP) ###-####
                country = value.slice(0, 3);
                city = value.slice(3, 5);
                number = value.slice(5);
                break;

            default:
                return tel;
        }

        if (country == 1) {
            country = "";
        }

        number = number.slice(0, 3) + '-' + number.slice(3);

        return (country + " (" + city + ") " + number).trim();
    };
});


