<title><?php echo CHtml::encode($this->pageTitle); ?></title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8">
<meta name="viewport" content="width=1280">
<meta name="description" content="">
<meta name="author" content="">

<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon">
<!-- Google-Fonts -->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/css.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/my_style.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" rel="stylesheet" media="print">
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/non-responsive.css">
<!---->
<!--<!-- Bootstrap core CSS -->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/bootstrap-reset.css" rel="stylesheet">

<!--Animation css-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/animate.css" rel="stylesheet">

<!--Icon-fonts css-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ionicons.css" rel="stylesheet">

<!--Morris Chart CSS -->
<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/morris.css">

<!-- Select -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/select2/select2.css" />

<!-- Datapicker -->
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/timepicker/bootstrap-datepicker.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/timepicker/bootstrap-timepicker.min.css" />

<!-- Custom styles for this template -->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/helper.css" rel="stylesheet">
<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/sweet-alert.css" rel="stylesheet">

<!-- DataTables -->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
<!--ng-table-->
		<link href="<?php echo Yii::app()->request->baseUrl; ?>/css/ng-table.min.css" rel="stylesheet" />

<!-- Plugins css -->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/modal-effect/css/component.css" rel="stylesheet">

<!--bootstrap-wysihtml5-->
<link href="<?php echo Yii::app()->request->baseUrl; ?>/js/lib/summernote/summernote.css" rel="stylesheet" />

<!--[if lt IE 9]>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/html5shiv.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/respond.min.js"></script>
<![endif]-->

<?php

$baseUrl = Yii::app()->getBaseUrl(true);
$cs = Yii::app()->clientScript;

$cs->registerScriptFile($baseUrl . '/js/lib/jquery.min.js');
$cs->registerScriptFile($baseUrl . '/js/lib/bootstrap.js');
$cs->registerScriptFile($baseUrl . '/js/lib/angular.min.js');
$cs->registerScriptFile($baseUrl . '/js/lib/angular-local-storage.min.js');
$cs->registerScriptFile($baseUrl . '/js/lib/angular-sanitize.min.js');
$cs->registerScriptFile($baseUrl . '/js/lib/select.js');
$cs->registerScriptFile($baseUrl . '/js/lib/ui-bootstrap-tpls-1.1.2.min.js');
$cs->registerScriptFile($baseUrl . '/js/lib/mask.min.js');
$cs->registerScriptFile($baseUrl . '/js/lib/ng-table.js');



$cs->registerScriptFile($baseUrl . '/js/lib/pace.js');
$cs->registerScriptFile($baseUrl . '/js/lib/wow.js');
$cs->registerScriptFile($baseUrl . '/js/lib/jquery.js');
//$cs->registerScriptFile($baseUrl . '/js/lib/bootstrap.js');
$cs->registerScriptFile($baseUrl . '/js/lib/sweet-alert.js');


//$cs->registerScriptFile($baseUrl . '/js/lib/modal-effect/js/classie.js');
//$cs->registerScriptFile($baseUrl . '/js/lib/modal-effect/js/modalEffects.js');
//$cs->registerScriptFile($baseUrl . '/js/lib/timepicker/bootstrap-datepicker.js');
//$cs->registerScriptFile($baseUrl . '/js/lib/timepicker/bootstrap-datepicker.de.js');
//$cs->registerScriptFile($baseUrl . '/js/lib/jquery-multi-select/jquery.quicksearch.js');
//$cs->registerScriptFile($baseUrl . '/js/lib/select2/select2.min.js');
//
//$cs->registerScriptFile($baseUrl . '/js/lib/bootstrap-wysihtml5/wysihtml5-0.3.0.js');
//$cs->registerScriptFile($baseUrl . '/js/lib/bootstrap-wysihtml5/bootstrap-wysihtml5.js');
//$cs->registerScriptFile($baseUrl . '/js/lib/summernote/summernote.min.js');

$cs->registerScriptFile($baseUrl . '/js/app.js');
$cs->registerScriptFile($baseUrl . '/js/main.js');
$cs->registerScriptFile($baseUrl . '/js/network.js');

?>