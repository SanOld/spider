<?php
require_once ('utils/utils.php');
require_once ('utils/php.php');
require_once ('utils/responce.php');
require_once ('utils/auth.php');
require_once ('utils/email.php');

define('MODELS', 'User, UserType, UserTypeRight,
                  Page, PagePosition,
                  Relation,
                  Performer, PerformerDocument,
                  PaymentType, FinancialRequest, Rate,
                  FinancialRequestStatus,
                  Summary,
                  School, SchoolType,
                  Project, ProjectType,
                  District,
                  Hint,
                  BankDetails,
                  FinanceSource,
                  Request, RequestStatus, RequestSchoolConcept, RequestSchoolGoal, RequestSchoolFinance,
                  SystemModel,
                  AuditTables, Audit,
                  DocumentTemplate, DocumentTemplateType, DocumentTemplatePlaceholder, EmailTemplate,
                  RemunerationLevel, RequestFinancialGroup, RequestUser, RequestProfAssociation,
                  UserLock');

class BaseController extends Controller {
  private $method = false;
  private $model;

  public function actionIndex() {
    $models = $models_prot = array_map('trim', explode(',', MODELS));
    $models = array_change_case($models);
    if(isset($_GET['model'])) {
      switch($_GET['model']) {
        case 'login':
          $auth = new Auth();
          $res = $auth->login($_GET);
          response($res['code'], $res);
          break;
//        case 'relation':
//          response(200, $this->getRelation());
//          break;
        case 'logout':
          $auth = new Auth();
          $res = $auth->logout();
          break;
        case 'forgot_password':
          $auth = new Auth();
          if($user = $auth->checkEmail(post('email'))) {
            return Email::doRecovery($user, $auth->getRecoveryLink($user));
          } else {
            response(409, array('system_code' => 'ERR_RECOVERY_EMAIL', 'silent' => true));
          }
          break;
        case 'reset_password':
          $auth = new Auth();
          parse_str(file_get_contents("php://input"), $post_vars);
          if($user = $auth->checkRecoveryToken(get('recovery_token'))) {
            $auth->updatePassword($user, safe($post_vars, 'password'));
            $auth->login(array('login' => $user['login'], 'password' => safe($post_vars, 'password')));
            response(200, array('system_code' => 'SUCCESSFUL', 'login' => $user['login']));
          } else {
            response(409, array('system_code' => 'ERR_INVALID_TOKEN'));
          }
          break;

      }
      $key = array_search(self::getClassName($_GET['model']), $models);
      if($key !== false) {
        $modelFor = $models_prot[$key]; // unix files 'user' and 'User' are not equal
      } else {
        response('405', array('sestem_code' => 'ERR_SERVICE'));
      }
    }

    $this -> model = CActiveRecord::model($modelFor);
    $headers = getallheaders ();
    $this -> method = strtolower($_SERVER['REQUEST_METHOD']);
    $auth = new Auth(safe($headers,'Authorization'));

    if(!$auth ->isActive() || !$auth ->checkToken()) {
      $error = $auth->getAuthError();
      response('401', $error);
    } else {
      $session_params = 'SET @user_id='.$auth->user['id'].';';
      Yii::app ()->db->createCommand ($session_params)->execute();
    }

    $this -> model -> user = $auth -> user;

    $this -> model -> isFilter = !!safe($_GET, 'filter');

//    $permissionField = in_array($this -> method, array('post', 'put', 'delete', 'patch')) ? 'can_edit' : 'can_view';
//
//    if(!($permissionField == 'can_view' && $this->model->isFilter) && !($this -> method == 'put' && safe($_GET,'id') == $auth -> user['id']) && !$auth->user[$permissionField]) {
//      $this->sendPermissionError();
//    }

    if($this -> method) {
      switch ($this -> method) {
        case 'get' :
          $this -> model ->select($_GET);
          break;
        case 'post' :
          if($_GET['model'] == 'SystemModel') {
            if($auth->user['type'] == 'a') {
              switch($_POST['run']) {
                case 'startAllTablesAudit':$this -> model ->startAllTablesAudit();
                  break;
                case 'updateTablesAudit':$this -> model ->updateTablesAudit();
                  break;
                case 'deleteTablesAudit':$this -> model ->deleteTablesAudit();
                  break;
                case 'updateReuest':$this -> model ->updateReuest();
                  break;
              }

            } else {
              response('403', array ( 'result'      => false
                                    , 'system_code' => 'ERR_PERMISSION'
                                    , 'code'        => '403'
                                    ));
            }
          } elseif($_GET['model'] == 'request' && isset($_POST['copy']) ){
            $this -> model ->copy($_POST);
          } elseif($_GET['model'] == 'request' && isset($_POST['massCreate']) ){
            $this -> model ->massCreate($_POST);
          }else {
            $this -> model ->insert($_POST);
          }
          break;
        case 'put' :
          $post_vars = array ();
          parse_str(file_get_contents("php://input"), $post_vars);
          $id = safe($_GET,'id');
          $this -> model ->update($id, $post_vars);
          break;
        case 'patch' :
          $post_vars = array ();
          parse_str(file_get_contents("php://input"), $post_vars);
          if(safe($post_vars, 'ids')) {
            $ids = !is_array($post_vars['ids']) ? array($post_vars['ids']) : $post_vars['ids'];
            unset($post_vars['ids']);
            foreach($ids as $id) {
              $this -> model ->update($id, $post_vars, true);
            }
            response(200, array ('result' => true, 'system_code' => 'SUCCESSFUL'), 'patch');
          }
          break;
        case 'delete' :
            $id = safe($_GET,'id');
            $this -> model ->delete($id);
          break;
      }
    }
  }

  public function demo()
  {
    if(Yii::app()->params['hideDemo']) {
      echo(' style="display:none;" ');
    }
  }

  protected function sendPermissionError() {
    response ( '403', array (
      'result' => false,
      'system_code' => 'ERR_PERMISSION'
    ), $this->method );
  }

  static protected function getClassName($model) {
    return strtoupper(str_replace('_', '', $model));
  }

//  function getRelation() {
//    return array(
//      array('id' => 'a', 'code' => 'no_relation', 'name' => 'Keine Verbindung'),
//      array('id' => 'd', 'code' => 'district',    'name' => 'Bezirk'),
//      array('id' => 't', 'code' => 'performer',   'name' => 'Träger Agentur'),
//      array('id' => 's', 'code' => 'school',      'name' => 'Schule'),
//    );
//  }

  protected function checkAuth() {
    $headers = getallheaders ();
    if (isset ( $headers ['Authorization'] ) && $headers ['Authorization']) {
      $auth = new Auth($headers['Authorization']);

      $this->user = $auth->getUser();
      if ($this->user && $this->user['is_enabled'] == 0){
        return array (
            'result' => false,
            'system_code' => 'ERR_USER_DISABLED',
            'code' => '403'
        );
      }
      if ( $auth->checkToken() ) {
        return array (
            'result' => $this->user,
            'system_code' => 'SUCCESSFUL',
            'code' => '200'
        );
      } elseif ($auth->isTokenExists()) {
        return array (
            'result' => false,
            'system_code' => 'ERR_OUT_OF_DATE',
            'code' => '401'
        );
      } else {
        return array (
            'result' => false,
            'system_code' => 'ERR_INVALID_TOKEN',
            'code' => '403'
        );
      }
    } else {
      return array (
          'result' => false,
          'system_code' => 'ERR_TOKEN_MISSED',
          'code' => '403'
      );
    }
  }

  public function actionUploadFile($model) {
    function toBytes($str){
      $val = trim($str);
      $last = strtolower($str[strlen($str)-1]);
      switch($last) {
        case 'g': $val *= 1024;
        case 'm': $val *= 1024;
        case 'k': $val *= 1024;
      }
      return $val;
    }
    $dirpath = 'uploads/'.$model.'/';
    if(isset($_GET['id']) && is_numeric($_GET['id'])){
      $id = $_GET['id'];
      unset($_GET['id']);
      $strlength = strlen($id);
      for($i=0;$i<$strlength;$i++){
        $dirpath .=substr($id, $i, 1).'/';
      }
    }
    
    $allowedExtensions = array('jpg','jpeg','png', 'gif', 'doc', 'docx', 'pdf', 'csv');
    $sizeLimit = 10 * 1024 * 1024; // 10 Mb
    $postSize = toBytes(ini_get('post_max_size'));
    $uploadSize = toBytes(ini_get('upload_max_filesize'));
    $sizeLimit = min($sizeLimit, $postSize, $uploadSize);
    $path = $_SERVER['DOCUMENT_ROOT'].'/'.$dirpath;
    mk_dir($path);
    $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
    $result = $uploader->handleUpload($path);
    
    if(safe($result, 'success')) {
      $models = $models_prot = array_map('trim', explode(',', MODELS));
      $models = array_change_case($models);
      $key = array_search(self::getClassName($_GET['model']), $models);
      if($key !== false) {
        $modelFor = $models_prot[$key]; // unix files 'user' and 'User' are not equal
      } else {
        response('405', array('system_code' => 'ERR_SERVICE'));
      }
      $this -> model = CActiveRecord::model($modelFor);

      if($result['extention'] == 'csv'){
        $file = $result['directory'].$result['filename'];
        $result = $this -> model -> addContent($file);
      }else{
        $headers = getallheaders ();
        $this -> method = strtolower($_SERVER['REQUEST_METHOD']);
        $auth = new Auth(safe($headers,'Authorization'));

        if(!$auth ->checkToken()) {
          $error = $auth->getAuthError();
          response('401', $error);
        }

        $this -> model -> user = $auth -> user;
        if(!$auth->user['can_edit']) {
          $this->sendPermissionError();
        }
        $result = $this -> model -> addFile($id, $uploader->getName(), $dirpath.$result['filename']);
      }

    }
    echo htmlspecialchars(json_encode($result), ENT_NOQUOTES);
    }
}
