spi.controller('EmailTemplatesController', function ($scope, $rootScope, network, GridService) {
  $rootScope._m = 'email_template';
  $scope.filter = {};

  var grid = GridService();
  $scope.tableParams = grid('email_template', $scope.filter, {sorting: {name: 'asc'}});

  $scope.updateGrid = function () {
    grid.reload();
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
      controller: 'EditEmailTemplatesController',
      template: 'editTemplate.html'
    });
  };

  $scope.openTemplate = function (row, modeView) {
    grid.openEditor({
      data: row,
      hint: $scope._hint,
      modeView: !!modeView,
      size: 'width-full',
      controller: 'ShowEmailTemplatesController',
      template: 'showTemplate.html'
    });
  };

});

spi.controller('EditEmailTemplatesController', function ($scope, $rootScope, modeView, $uibModalInstance, data, network, hint, Utils, GridService) {
  $scope.isInsert = !data.id;
  $scope._hint = hint;
  $scope.modeView = modeView;
  $scope.filter = {is_email: 1};

  if (!$scope.isInsert) {
    $scope.docId = data.id;
    $scope.document = {
      id:           data.id,
      name:         data.name,
      description:  data.description,
      text:         data.text,
      subject:         data.subject
    };

  } else {

    $scope.document = {
      id: '',
      name:         '',
      description:  '',
      text:         '',
      subject:      ''
    };

  }

//  network.get('EmailTemplateType', {filter: 1}, function (result, response) {
//    if (result) {
//      $scope.documentTypes = response.result;
//    }
//  });

  var grid = GridService();
  $scope.tableParams = grid('document_template_placeholder', $scope.filter, {sorting: {name: 'asc'}});

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

  $scope.submitEmailTemplate = function () {
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
        network.post('email_template', $scope.document, callback);
      } else {
        network.put('email_template/' + data.id, $scope.document, callback);
      }
    }
  };

  $scope.remove = function () {
    Utils.doConfirm(function() {
      network.delete('email_template/' + data.id, function (result) {
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

spi.controller('ShowEmailTemplatesController', function ($scope, $rootScope, modeView, $uibModalInstance, data, network, hint, Utils, GridService) {
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