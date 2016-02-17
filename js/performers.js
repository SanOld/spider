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


spi.controller('ModalEditController', function ($scope, $uibModalInstance, data, network, hint, Utils) {
    $scope.$parent._m = 'performer';
    $scope.isInsert = !data.id;
    $scope._hint = hint;

    if(!$scope.isInsert) {
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
        //initUploader(data.id);
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
        $scope.documents = [];
        network.get('performer_document', {performer_id: data.id}, function(result, response){
            if(result) {
                $scope.documents = response.result;
            }
        });
    }

    $scope.removeDocument = function(docId) {

    };

    $scope.changeRepresentativeUser = function(userId) {
        $scope.representativeUser = Utils.getRowById($scope.users, userId);
    };

    $scope.changeApplicationProcessingUser = function(userId) {
        $scope.applicationProcessingUser = Utils.getRowById($scope.users, userId);
    };

    $scope.changeBudgetProcessingUser = function(userId) {
        $scope.budgetProcessingUser = Utils.getRowById($scope.users, userId);
    };

    $scope.fieldError = function(field, innerForm) {
        var form = innerForm ? $scope.form[innerForm] : $scope.form;
        return ($scope.submited || form[field].$touched) && form[field].$invalid;
    };

    $scope.submitForm = function () {
        $scope.submited = true;
        $scope.form.$setPristine();
        if ($scope.form.$valid) {
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



    function initUploader(performerId) {
        var uploader = new qq.FileUploader({
            element: $('#file_upload')[0],
            action: '/api/upload-document/'+performerId,
            uploadButtonText: '',
            validation: {
                allowedExtensions: ['doc', 'pdf'],
                itemLimit: 5,
                sizeLimit: 10485760 // 10 Mb
            },
            onComplete: function(id, fileName, responseJSON){
                var results = responseJSON.success || false;
                var error = responseJSON.error || 'Error';
                if(results) {
                    var realFileName = responseJSON.filename || fileName;
                    $timeout(function(){
                        if(!imagesIsFull($scope.documents)) {
                            $scope.documents.push({'url':'/files/uploads/'+realFileName, 'name':realFileName});
                        }
                    });
                }
            },
            onUpload: function(id, fileName, xhr) {
            },
            onProgress: function(id, fileName, loaded, total) {
            },
            onError: function(id, fileName, xhr){
            }
        });
    }



});