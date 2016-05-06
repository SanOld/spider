spi.controller('ResetPasswordController', function($scope, network) {

    $scope.fieldError = function(field) {
        return ($scope.submited || $scope.form[field].$touched) && $scope.form[field].$invalid;
    };

    $scope.submitForm = function () {
        $scope.submited = true;
        $scope.error = false;
        $scope.form.$setPristine();
        if ($scope.form.$valid) {
            network.put('reset_password'+location.search, {password: $scope.password}, function(result, response) {
                if(!result) {
                    $scope.error = true;
                } else {
                    network.connect(response.login, $scope.password, function(result, response){
                        if(result) {
                            window.location = '/dashboard';
                        }
                    });
                }
            });
        }
    };

});
