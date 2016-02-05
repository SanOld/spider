
spi.controller('main', function($scope, network, GridService) {
    $scope.isLogin = network.isLogined();
    if($scope.isLogin) {
        $scope.user = network.user;
    } else {
        window.location = '/'
    }

    $scope.logout = function(){
        network.logout();
    };
    network.onLogout = function(){
        window.location = '/'
    };

    $scope.openEdit = function () {
        GridService().openEditor({
            data: $scope.user,
            controller: 'ModalEditUserController',
            template: 'editUserTemplate.html'
        }, function(){
            $scope.user = network.user;
        });

    };

});

spi.controller('ModalEditUserController', function ($scope, $uibModalInstance, data, network, localStorageService) {
    $scope.isInsert = true;
    $scope.user = {
        is_active: 1,
        is_finansist: 0,
        sex: 1
    };

    if(data.id) {
        $scope.isInsert = false;
        $scope.userId = data.id;
        $scope.curentPassword = localStorageService.get('password');
        $scope.type_name = data.type_name;
        $scope.relation_name = data.relation_name;
        $scope.user = {
            is_active: +data.is_active,
            is_finansist: +data.is_finansist,
            sex: +data.sex,
            title: data.title,
            first_name: data.first_name,
            last_name: data.last_name,
            login: data.login,
            email: data.email,
            phone: data.phone

        };
        $scope.isCurrentUser = network.user.id == data.id;
    } else {
        network.get('user_type', {}, function (result, response) {
            if(result) {
                $scope.userTypes = response.result;
            }
        });
    }

    $scope.fieldError = function(field) {
        return (($scope.submited || $scope.form[field].$touched) && $scope.form[field].$invalid) || ($scope.error && $scope.error[field] != undefined && $scope.form[field].$pristine);
    };

    $scope.submitForm = function (formData) {
        $scope.error = false;
        $scope.submited = true;
        $scope.form.$setPristine();
        if ($scope.form.$valid && isCurrentValid()) {
            var callback = function (result, response) {
                if(result) {
                    if($scope.isCurrentUser) {
                        network.reconnect(function() {
                            $uibModalInstance.close();
                        });
                    } else {
                        $uibModalInstance.close();
                    }
                } else {
                    setError(response.system_code);
                }
                $scope.submited = false;
            };
            if($scope.isInsert) {
                network.post('user', formData, callback);
            } else {
                network.put('user/'+data.id, formData, callback);
            }
        }
    };

    $scope.remove = function(id) {
        network.delete('user/'+id, function (result) {
            if(result) {
                $uibModalInstance.close();
            }
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };

    function isCurrentValid() {
        if(!$scope.isCurrentUser) {
            return true;
        } else if(!$scope.form.password.$viewValue) {
            return true
        }
        return $scope.form.old_password.$viewValue == $scope.curentPassword;
    }

    function setError(code) {
        var result = false;
        switch (code) {
            case 'ERR_DUPLICATED':
                result = {login: {dublicate: true}};
                break;
            case 'ERR_DUPLICATED_EMAIL':
                result = {email: {dublicate: true}};
                break;
        }
        $scope.error = result;
    }
});