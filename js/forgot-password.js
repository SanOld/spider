spi.controller('ForgotPasswordController', function($scope, network) {

    $scope.fieldError = function() {
        return ($scope.submited && $scope.form.email.$invalid) || ($scope.error && $scope.form.email.$pristine);
    };

    $scope.submitForm = function () {
        $scope.submited = true;
        $scope.error = false;
        $scope.form.$setPristine();
        if ($scope.form.$valid) {
            network.post('forgot_password', {email: $scope.email}, function(result, response) {
                $scope.error = !result || response.result;
                if(!$scope.error) {
                    $scope.success = true;
                }
            });
        }
    };

});
