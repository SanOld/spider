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

spi.directive("qqFileUpload", function(Notification) {
    return {
        restrict: 'A',
        scope: {
            setting: '='
        },
        template: '<div class="btn w-sw custom-color pull-right" id="file-uploader"></div>',
        link: function(scope, element, attrs, ctrl) {
            var uploader = new qq.FileUploader({
                element: document.getElementById('file-uploader'),
                action: '/api/upload-file/'+scope.setting.model+'/'+(scope.setting.params ? '?'+$.param(scope.setting.params) : ''),
                uploadButtonText: scope.setting.buttonText || '',
                sizeLimit: scope.setting.sizeLimit || 10520000,
                allowedExtensions: scope.setting.allowedExtensions || ['doc', 'docx', 'pdf'],
                messages: {
                    typeError: "Unfortunately the file(s) you selected weren't the type we were expecting. Only {extensions} files are allowed.",
                    sizeError: "{file} is too large, maximum file size is {sizeLimit}.",
                    minSizeError: "{file} is too small, minimum file size is {minSizeLimit}.",
                    emptyError: "{file} is empty, please select files again without it.",
                    onLeave: "The files are being uploaded, if you leave now the upload will be cancelled."
                },
                showMessage: function(message){
                    Notification.error({title: 'File upload error', message: message});
                },
                onComplete: (scope.setting.onCompile) || function(id, fileName, responseJSON){
                    Notification.success(responseJSON.message);
                },
                onUpload: scope.setting.onUpload || function(id, fileName, xhr){},
                onProgress: scope.setting.onProgress || function(id, fileName, loaded, total){},
                onError: scope.setting.onError || function(id, fileName, xhr){
                    Notification.error(responseJSON.message);
                }
            });
        }
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


