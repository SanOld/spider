spi.controller('ForgotPasswordController', function($scope, network, SweetAlert) {

    $scope.fieldError = function() {
        return ($scope.submited && $scope.form.email.$invalid) || ($scope.error && $scope.form.email.$pristine);
    };

    $scope.submitForm = function () {
        $scope.submited = true;
        $scope.error = false;
        $scope.form.$setPristine();
        if ($scope.form.$valid) {
            network.post('forgot_password', {email: $scope.email}, function(result, response) {
                $scope.error = !result;
                if(result) {
                    SweetAlert.swal({
                            title: "Passwort zurücksetzen",
                            text: "Eine E-Mail mit Anweisungen wurde an Ihre E-Mail-Adresse gesendet.",
                            type: "success",
                            confirmButtonText: "Auf die Startseite",
                            closeOnConfirm: false
                        }, function(isConfirm){location.href = '/'});
                }
            });
        }
    };

});
