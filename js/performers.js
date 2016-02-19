spi.controller('PerformerController', function($scope, network, GridService, HintService) {
    $scope.$parent._m = 'performer';
    $scope.filter = {is_checked: 1};
    $scope.checks = [{id: 1, name: 'Checked'}, {id: 0, name: 'Not checked'}];

    var grid = GridService();
    $scope.tableParams = grid($scope.$parent._m, $scope.filter, {sorting: {name: 'asc'}});

    $scope.updateGrid = function() {
        grid.reload();
    };

    HintService($scope.$parent._m, function(result) {
         $scope._hint = result;
    });

    $scope.resetFilter = function() {
        $scope.filter = grid.resetFilter();
    };

    $scope.openEdit = function (row) {
        grid.openEditor({data: row, hint: $scope._hint, size: 'width-full'});
    };


});


spi.controller('ModalEditController', function ($scope, $uibModalInstance, data, network, hint, Utils, Notification, SweetAlert) {
    $scope.$parent._m = 'performer';
    $scope.isInsert = !data.id;
    $scope._hint = hint;
    $scope.fullAccess = network.user.type_id == 1 || network.user.type_id == 2;
    $scope.tabs = [{active: true}];


    if(!$scope.isInsert) {
        $scope.documents = [];
        $scope.performer = {
            name: data.name,
            short_name: data.short_name,
            address: data.address,
            plz: data.plz,
            city: data.city,
            phone: data.phone,
            email: data.email,
            homepage: data.homepage,
            company_overview: data.company_overview,
            diversity: data.diversity,
            further_education: data.further_education,
            quality_standards: data.quality_standards,
            comment: data.comment,
            is_checked: data.is_checked,
            representative_user_id: data.representative_user_id,
            application_processing_user_id: data.application_processing_user_id,
            budget_processing_user_id: data.budget_processing_user_id,
            bank_details_id: data.bank_details_id,
        };
        getUsers();
        if(data.bank_details_id) {
            getBankDetails();
        }
        getDocuments();
        $scope.qqSetting = {
            model: 'performer_document',
            params: {id: data.id},
            buttonText: 'Dokumente hinzufügen',
            onCompile: function(id, fileName, responseJSON){
                if(responseJSON.result) {
                    Notification.success({title: 'File upload success!', message: responseJSON.message});
                    getDocuments();
                } else {
                    Notification.error({title: 'File upload fail!', message: responseJSON.message});
                }
            }
        }

    } else {
        $scope.performer = {is_checked: 0};
    }


    function getUsers() {
        network.get('user', {}, function(result, response){
            if(result) {
                $scope.users = response.result;
                if(data.is_checked) {
                    $scope.checkedBy = Utils.getRowById($scope.users, data.checked_by, 'name');
                    $scope.checkedDate = data.checked_date_formatted;
                }
                if(data.representative_user_id) {
                    $scope.representativeUser = Utils.getRowById($scope.users, data.representative_user_id);
                }
                if(data.application_processing_user_id) {
                    $scope.applicationProcessingUser = Utils.getRowById($scope.users, data.application_processing_user_id);
                }
                if(data.budget_processing_user_id) {
                    $scope.budgetProcessingUser = Utils.getRowById($scope.users, data.budget_processing_user_id);
                }
            }
        });
    }

    function getBankDetails() {
        network.get('bank_details', {id: data.bank_details_id}, function(result, response){
            if(result) {
                $scope.showBankDetails = true;
                $scope.bank_details = response.result[0];
            }
        });
    }

    function getDocuments() {
        network.get('performer_document', {performer_id: data.id}, function(result, response){
            if(result) {
                $scope.documents = response.result;
            }
        });
    }

    $scope.changeRepresentativeUser = function(userId) {
        $scope.representativeUser = Utils.getRowById($scope.users, userId);
    };

    $scope.changeApplicationProcessingUser = function(userId) {
        $scope.applicationProcessingUser = Utils.getRowById($scope.users, userId);
    };

    $scope.changeBudgetProcessingUser = function(userId) {
        $scope.budgetProcessingUser = Utils.getRowById($scope.users, userId);
    };

    $scope.fieldError = function(innerForm, field) {
        var form = innerForm ? $scope.form[innerForm] : $scope.form;
        return ($scope.submited || form[field].$touched) && form[field].$invalid;
    };

    $scope.submitFormPerformer = function () {
        $scope.submited = true;
        $scope.form.formPerformer.$setPristine();
        if ($scope.form.formPerformer.$valid) {
            var callback = function (result, response) {
                if (result) {
                    $uibModalInstance.close();
                }
                $scope.submited = false;
            };
            if ($scope.isInsert) {
                network.post($scope.$parent._m, $scope.performer, callback);
            } else {
                network.put($scope.$parent._m + '/' + data.id, $scope.performer, callback);
            }
        } else {
            $scope.tabs[0].active = true;
        }
    };

    $scope.saveBankDetails = function(formData) {
        $scope.submited = true;
        $scope.form.formBank.$setPristine();
        if ($scope.form.formBank.$valid) {
            if (!$scope.performer.bank_details_id) {
                network.post('bank_details', formData, function (result, response) {
                    if (result) {
                        $scope.performer.bank_details_id = response.id;
                    }
                });
            } else {
                network.put('bank_details/' + $scope.performer.bank_details_id, formData);
            }
        }
    };

    $scope.removeBankDetails = function(id) {
        network.delete('bank_details/'+id, function (result) {
            if(result) {
                $scope.performer.bank_details_id = null;
                $scope.bank_details = {};
            }
        });
    };

    $scope.removeDocument = function(docId) {
        SweetAlert.swal({
                title: "Sind Sie sicher?",
                text: "Diese Datei wird nicht wiedererstellt!",
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Abbrechen",
                confirmButtonText: "Ja, löschen!",
                closeOnConfirm: false},
            function(isConfirm){
                if (isConfirm) {
                    network.delete('performer_document/'+docId, function(result, response){
                        SweetAlert.swal("Gelöscht!", "Ihre Datrei ist erfolgreich gelöscht!", "success");
                        getDocuments();
                    }, false);
                }
            }
        );
    };

    $scope.remove = function() {
        network.delete($scope.$parent._m+'/'+data.id, function (result) {
            if(result) {
                $uibModalInstance.close();
            }
        });
    };

    $scope.cancel = function () {
        $uibModalInstance.dismiss('cancel');
    };

});