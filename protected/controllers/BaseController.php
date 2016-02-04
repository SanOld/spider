<?php
require_once ('utils/utils.php');
require_once ('utils/php.php');
require_once ('utils/responce.php');
require_once ('utils/auth.php');

define('MODELS', 'User');
// define('SURVEY_DIR', '/surveys/');
class BaseController extends Controller {
  private $method = false;
  private $model;
  public function actionIndex() {
    $models_prot = explode(',', MODELS);
    $models = explode(',', MODELS);
    $models = array_change_case($models);
    if(isset($_GET['model'])) {
      if($_GET['model'] == 'login') {
        
        $auth = new Auth();
        $res = $auth->login($_GET);
    
        response($res['code'], $res);
      }
      $key = array_search(strtoupper($_GET['model']), $models);
      if($key !== false) {
        $modelFor = $models_prot[$key]; // unix files 'user' and 'User' are not equal
      } else {
        response('405', array('sestem_code' => 'ERR_SERVICE'));
      }
    }
    
    $this -> model = CActiveRecord::model($modelFor);
    $classname = get_class($this -> model);
    $chartypes = array (
        'CHAR',
        'VARCHAR',
        'TEXT' 
    );
//    $errors = array ();
//    $success = array ();
    $headers = getallheaders ();
    
    $this -> method = strtolower($_SERVER['REQUEST_METHOD']);
    $auth = new Auth(safe($headers,'Authorization'));
//    $id = false;
//    $token = false;
//    $chekAuth = false;

    if(!$auth ->checkToken()) {
      $error = $auth->getAuthError();
      response('401', $error);
    }
    
    $this -> model -> user = $auth -> user;
//    if($chekAuth != false) {
//      $token = $chekAuth['token'];
//      $id = $chekAuth['id'];
//      $user = $chekAuth['user'];
//      $priv = $chekAuth['priv'];
//    }
    if($this -> method) {
      switch ($this -> method) {
        case 'get' :
    
            $this -> model ->select($_GET);
//            if(in_array($priv, explode(',', $classname::SELECT_PERMISSION))) {
//              $neededFields = explode(',', $classname::SELECT_FIELDS_LIST);
//              $condition = false;
//              $criteria = new CDbCriteria();
//              if($classname::SELECT_ORDER != '') {
//                $criteria -> order = $classname::SELECT_ORDER;
//                $condition = true;
//              }
//              foreach($neededFields as &$value ) {
//                if(isset($_GET[$value])) {
//                  $column_type = $this -> model -> tableSchema -> getColumn($value) -> dbType;
//                  $column_type = explode('(', $column_type);
//                  $condition = true;
//                  if(in_array(strtoupper($column_type[0]), $chartypes)) {
//                    $criteria -> addCondition($value . ' LIKE :' . $value);
//                    $criteria -> params[':' . $value] = '%' . safe($_GET, $value, null) . '%';
//                  } else {
//                    $criteria -> addCondition($value . '=:' . $value);
//                    $criteria -> params[':' . $value] = safe($_GET, $value, null);
//                  }
//                }
//              }
//              unset($value);
//              $criteria = $this -> model -> applyPermissionFilter($criteria);
//              if($id) {
//                $result = $this -> model -> findAll('id=:id', array (
//                    ':id' => $id 
//                ));
//              } else {
//                if(!$condition) {
//                  $result = $this -> model -> findAll();
//                } else {
//                  $result = $this -> model -> findAll($criteria);
//                }
//              }
//              $success = unserialize(SUCCESSFUL);
//              foreach($result as &$value ) {
//                $success['data'][] = array_merge($value -> getAttributes($neededFields), $value -> getRelatedRecords());
//              }
//              unset($value);
//              $success['message'] = 'Successfully selected';
//              break;
//            } else {
//              $errors = unserialize(ERR_PERMISSION);
//              $errors['message'] = 'You have no priveleges to select ' . $classname;
//              break;
//            }
          break;
        case 'post' :
          $this -> model ->insert($_POST);
//          {
//            if(in_array($priv, explode(',', $classname::INSERT_PERMISSION))) {
//              $needForSave = explode(',', $classname::INSERT_FIELDS_LIST);
//              $diff = array_diff($needForSave, array_keys($_POST));
//              if($diff) {
//                $message = 'Not all parameters setted - ' . implode(', ', $diff);
//                $errors = unserialize(ERR_MISSED_REQUIRED_PARAMETERS);
//                $errors['message'] = $message;
//                break;
//              } else {
//                $class = new ReflectionClass($classname);
//                $insmodel = $class -> newInstance();
//                $insmodel -> creator = $user;
//                ;
//                $errors = $insmodel -> chekInsertUpdateParams($_POST);
//                if(!$errors) {
//                  $insmodel -> attributes = $_POST;
//                  if($insmodel -> save(true)) {
//                    $success = unserialize(SUCCESSFUL);
//                    $success['message'] = 'Successfully saved';
//                    $success['new_id'] = $insmodel -> id; 
//                    //Yii::app() -> db -> getLastInsertID();
//                  } else {
//                    $errors = unserialize(ERR_QUERY);
//                    $errors['message'] = 'Error while save occurs';
//                  }
//                }
//              }
//            } else {
//              $errors = unserialize(ERR_PERMISSION);
//              $errors['message'] = 'You have no priveleges to insert ' . $classname;
//            }
//            break;
//          }
          break;
        case 'put' :
          $post_vars = array ();
          parse_str(file_get_contents("php://input"), $post_vars);
          $id = safe($_GET,'id');
          $this -> model ->update($id, $post_vars);
//          {
//            if(in_array($priv, explode(',', $classname::UPDATE_PERMISSION))) {
//              if($id) {
//                $canBeUpdated = explode(',', $classname::UPDATE_FIELDS_LIST);
//                $post_vars = array ();
//                parse_str(file_get_contents("php://input"), $post_vars);
//                $diff = array_diff(array_keys($post_vars), $canBeUpdated);
//                if(!$diff && !empty($post_vars)) {
//                  $updModel = $classname::model() -> find('id=:id', array (
//                      ':id' => $id 
//                  ));
//                  $updModel -> creator = $user;
//                  if($updModel) {
//                    $errors = $updModel -> chekInsertUpdateParams($post_vars);
//                    if(!$errors) {
//                      $updModel -> attributes = $post_vars;
//                      if($updModel -> save(true)) {
//                        $success = unserialize(SUCCESSFUL);
//                        $success['message'] = 'Successfully updated';
//                      } else {
//                        $errors = unserialize(ERR_QUERY);
//                        $errors['message'] = 'Error while update occurs';
//                      }
//                    }
//                  } else {
//                    $errors = unserialize(ERR_REQUEST_PARAMETERS);
//                    $errors['message'] = 'Incorrect id. The ' . $classname . ' not found with requested id';
//                  }
//                } else {
//                  $errors = unserialize(ERR_REQUEST_PARAMETERS);
//                  $errors['message'] = 'Not or invalid parameters setted - ' . implode(', ', $diff);
//                }
//              } else {
//                $errors = unserialize(ERR_REQUEST_PARAMETERS);
//                $errors['message'] = 'Id must be set for update.';
//              }
//            } else {
//              $errors = unserialize(ERR_PERMISSION);
//              $errors['message'] = 'You have no priveleges to update ' . $classname;
//            }
//            break;
//          }
          break;
        case 'delete' :
            $id = safe($_GET,'id');
            $this -> model ->delete($id);
          break;
      }
    }
    if($errors) {
      response($errors);
    } else {
      response($success);
    }
  }
  
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
  
//  private function chekAuth() {
//    $errors = array ();
//    $success = array ();
//    $token = false;
//    if(isset($_GET['token']) && !empty($_GET['token'])) {
//      $token = safe($_GET, 'token', null);
//    }
//    if($token) {
//      $user = User::model() -> find('token=:token', array (
//          ':token' => $_GET['token'] 
//      ));
//      if($user) {
//        // print_r($user);
//        $resauth = $user -> authentificate($_GET['token']);
//        if(isset($resauth['token'])) {
//          $priv = $user -> getPriveleges();
//          // if($priv == 'SUPERADMIN') {
//          $path = $_SERVER['REQUEST_URI'];
//          preg_match('@/api/([^\?]+)(\?|$)@', $path, $matches);
//          $res = $matches[1];
//          $list = explode('/', $res);
//          $id = (isset($list[1]) && $list[1] != '' && is_numeric($list[1])) ? (int)$list[1] : false;
//          // $this->id=Yii::app()->request->getParam('id')?Yii::app()->request->getParam('id'):false;
//          $this -> method = strtolower($_SERVER['REQUEST_METHOD']);
//          $success['priv'] = $priv;
//          $success['id'] = $id;
//          $success['user'] = $user;
//          $success['token'] = $token;
//        } else {
//          $errors = unserialize(ERR_TOKEN_OUT_OF_DATE);
//          $errors['message'] = $resauth['error_time'];
//          $errors = array_merge($errors, $resauth); // For mobile part
//        }
//      } else {
//        $errors = unserialize(ERR_TOKEN);
//        $errors['message'] = 'You have taken incorrect token';
//      }
//    } else {
//      $errors = unserialize(ERR_TOKEN);
//      $errors['message'] = 'Token must be setted';
//    }
//    if($errors) {
//      response($errors);
//      exit();
//    } else {
//      return $success;
//    }
//  }
}