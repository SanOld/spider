spi.controller('DocumentTemplatesController', function ($scope, $rootScope, network, GridService, HintService) {
  $rootScope._m = 'document_templates';
  $scope.filter = {};

  var grid = GridService();
  $scope.tableParams = grid('DocumentTemplate', $scope.filter, {sorting: {name: 'asc'}});

  $scope.updateGrid = function () {
    grid.reload();
  };

  HintService('document_templates', function (result) {
    $scope._hint = result;
  });

  network.get('DocumentTemplateType', {filter: 1}, function (result, response) {
    if (result) {
      $scope.documentTypes = response.result;
    }
  });



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

});

spi.controller('EditDocumentTemplatesController', function ($scope, $rootScope, modeView, $uibModalInstance, data, network, hint, Utils, GridService) {
  $scope.isInsert = !data.id;
  $scope._hint = hint;
  $scope.modeView = modeView;
  $scope.filter = {};

  if (!$scope.isInsert) {
    $scope.docId = data.id;
    $scope.document = {
      id:           data.id,
      name:         data.name,
      type_id:      data.type_id,
//      type_name:    data.type_name,
//      last_change:  data.last_change,
//      user_id:      data.user_id,
//      user_name:    data.user_name,
      text:         data.text,
    };

    $scope.filter = {type_id: data.type_id};

  } else {

    $scope.document = {
      id: '',
      name:         '',
      type_id:      1,
      text:         ''
    };
//    network.get('DocumentTemplate', {get_next_id: 1}, function (result, response) {
//      if (result) {
//        next_id = response.next_id;
//      }
//    });
  }

  network.get('DocumentTemplateType', {filter: 1}, function (result, response) {
    if (result) {
      $scope.documentTypes = response.result;
    }
  });

  var grid = GridService();
  $scope.tableParams = grid('DocumentTemplatePlaceholder', $scope.filter, {sorting: {name: 'asc'}});

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
      if ($scope.isInsert) {
        network.post('DocumentTemplate', $scope.document, callback);
      } else {
        network.put('DocumentTemplate/' + data.id, $scope.document, callback);
      }
    }
  };

  $scope.remove = function () {
    Utils.doConfirm(function() {
      network.delete('DocumentTemplate/' + data.id, function (result) {
        if (result) {
          Utils.deleteSuccess();
          $uibModalInstance.close();
        }
      });
    });
  };

  $scope.cancel = function () {
    $uibModalInstance.dismiss('cancel');
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

spi.controller('ShowDocumentTemplatesController', function ($scope, $rootScope, modeView, $uibModalInstance, data, network, hint, Utils, GridService) {
  $scope.isInsert = !data.id;
  $scope._hint = hint;
  $scope.modeView = modeView;
  $scope.filter = {};

  if (!$scope.isInsert) {
    $scope.document = {
      text: data.text
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