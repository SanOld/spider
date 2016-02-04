spi.controller('LoginController', function($scope, network, localStorageService) {

    if(localStorageService.get('remember') == 1) {
        $scope.user = {
            remember: 1,
            login: localStorageService.get('login') || '',
            password: localStorageService.get('password') || ''
        };
    }

    $scope.fieldError = function(field) {
        return ($scope.submited || $scope.form[field].$touched) && $scope.form[field].$invalid;
    };

    $scope.fieldSuccess = function(field) {
        return ($scope.submited || $scope.form[field].$touched) && $scope.form[field].$valid;
    };

    $scope.submitForm = function(user) {
        $scope.submited = true;
        if ($scope.form.$valid) {
            $scope.loginError = false;
            network.connect(user.login, user.password, function(result, response){
                if(result) {
                    localStorageService.set('login', user.remember == 1 ? user.login : '');
                    localStorageService.set('password', user.remember == 1 ? user.password : '');
                    localStorageService.set('remember', user.remember);
                    window.location = '/dashboard';
                } else {
                    $scope.loginError = true;
                }
            });
        }
        return false
    }

});
