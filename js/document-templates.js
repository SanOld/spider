spi.controller('DocumentTemplatesController', function ($scope, $rootScope, network, GridService) {
  $rootScope._m = 'document_template';
  $scope.filter = {};

  var grid = GridService();
  $scope.tableParams = grid('document_template', $scope.filter, {sorting: {name: 'asc'}});

  $scope.updateGrid = function () {
    grid.reload();
  };

  network.get('document_template_type', {filter: 1}, function (result, response) {
    if (result) {
      $scope.documentTypes = response.result;
    }
  });
  
  $scope.paramsForExport = {
    fileName: 'Druck-Templatesliste.csv',
    model: 'document_template',
    columns: {
      'name'        : 'Name',
      'type_name'   : 'Dokument-Typ',
      'last_change' : 'Letzte Änderung',
      'user_name'   : 'Benutzer des Änderung'
    },
    param: $scope.filter
  };

  $scope.resetFilter = function () {
    $scope.filter = grid.resetFilter();
  };

  $scope.openEdit = function (row, modeView) {
    grid.openEditor({
      data: row,
      hint: $scope._hint,
      modeView: !!modeView,
      size: 'width-full',
      controller: 'EditDocumentTemplatesController',
      template: 'editTemplate.html'
    });
  };

  $scope.openTemplate = function (row, modeView) {
    grid.openEditor({
      data: row,
      hint: $scope._hint,
      modeView: !!modeView,
      size: 'width-full',
      controller: 'ShowDocumentTemplatesController',
      template: 'showTemplate.html'
    });
  };

  $scope.getDate = function (date) {
    var result = '';
    if(date){
      result = new Date(date);
    }
    return result;
  }
});

spi.controller('EditDocumentTemplatesController', function ($scope, $rootScope, modeView, $uibModalInstance, data, network, hint, Utils, GridService, SweetAlert) {
  $scope.isInsert = !data.id;
  $scope._hint = hint;
  $scope.modeView = modeView;

  if (!$scope.isInsert) {
    $scope.docId = data.id;
    $scope.document = {
      id:           data.id,
      name:         data.name,
      type_id:      data.type_id,
      text:         data.text,
      is_prototype: data.is_prototype
    };
  } else {
    $scope.document = {
      id:     '',
      name:   '',
      text:   ''
    };
  }

  $scope.filter = {type_id: data.type_id, is_email: 0};

  network.get('document_template_type', {filter: 1}, function (result, response) {
    if (result) {
      $scope.documentTypes = response.result;
    }
  });



  var grid = GridService();
  $scope.tableParams = grid('document_template_placeholder', $scope.filter, {sorting: {name: 'asc'}});

  $scope.updateGrid = function () {
    grid.reload();
  };

  $scope.resetFilter = function () {
    $scope.filter = grid.resetFilter({type_id: data.type_id, is_email: 0});
  };

    network.get('document_template_placeholder', {filter: 1}, function (result, response) {
    if (result) {
      window.console.log(response.result);
    }
  });

  $scope.options = {
  height: 200,                 // set editor height
  focus: true,
  minHeight: null,             // set minimum height of editor
  maxHeight: null,             // set maximum height of editor
                   // set focus to editable area after initializing summernote
  toolbar: [
          ['edit',['undo','redo']],
          ['headline', ['style']],
          ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
          ['fontface', ['fontname']],
          ['textsize', ['fontsize']],
          ['fontclr', ['color']],
          ['alignment', ['ul', 'ol', 'paragraph', 'lineheight']],
          ['height', ['height']],
          ['table', ['table']],
          ['insert', ['link','picture','video']],
          ['view', ['fullscreen', 'codeview']],
          ['help', ['help']]
      ]
  };
  $scope.submitDocumentTemplate = function () {
    $scope.error = false;
    $scope.submited = true;
    $scope.form.formDocument.$setPristine();
    if ($scope.form.formDocument.$valid) {
      var callback = function (result, response) {
        if (result) {
          $uibModalInstance.close();
        } else {
          $scope.error = getError(response.system_code);
        }
        $scope.submited = false;
      };
      if(data.is_prototype == 0){
        if ($scope.isInsert) {
          network.post('document_template', $scope.document, callback);
        } else {
          network.put('document_template/' + data.id, $scope.document, callback);
        }
      }else{
        SweetAlert.swal({
          title: "Fehler",
          text: "Dieses Druck-Template kann nicht bearbeiten sein.",
          type: "error",
          confirmButtonText: "OK"
        });
      }
    }
  };
 
  $scope.remove = function () {
    Utils.doConfirm(function() {
      network.delete('document_template/' + data.id, function (result) {
        if (result) {
          Utils.deleteSuccess();
          $uibModalInstance.close();
        }
      });
    });
  };

  $scope.$on('modal.closing', function(event, reason, closed) {
    Utils.modalClosing($scope.form.formDocument, $uibModalInstance, event, reason);
  });

  $scope.cancel = function () {
    Utils.modalClosing($scope.form.formDocument, $uibModalInstance);
  };

  $scope.fieldError = function (field) {
    var form = $scope.form.formDocument;
    return form[field] && ($scope.submited || form[field].$touched) && form[field].$invalid || ($scope.error && $scope.error[field] != undefined && form[field].$pristine);
  };

  function getError(code) {
    var result = false;
    switch (code) {
      case 'ERR_DUPLICATED':
        result = {name: {dublicate: true}};
        break;
    }
    return result;
  }

});

spi.controller('ShowDocumentTemplatesController', function ($scope, $rootScope, modeView, $uibModalInstance, data, $sce, hint) {
  $scope.isInsert = !data.id;
  $scope._hint = hint;
  $scope.modeView = modeView;
  $scope.filter = {};

  $scope.trustAsHtml = function(string) {
    return $sce.trustAsHtml(string);
  };

  if (!$scope.isInsert) {
    $scope.document = {
      text: data.text,
      name: data.name
    };
  } else {
    $scope.document = {
      text: ''
    };
  }

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
  };

});
