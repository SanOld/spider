<?php

define ( 'PA', 'p' );
define ( 'TA', 't' );
define ( 'ADMIN', 'a' );
define ( 'SCHOOL', 's' );
define ( 'DISTRICT', 'd' );
define ( 'SENAT', 'g' );

class Auth {
  public $token = '';
  public $user = array();
  public $live = 12;

  public function __construct($token = false, $user = false) {

    if($token) {
      $this->token = $token;
      if($user) {
        $this->user = $user;
      } else {
        $this->user = Yii::app()->db
          ->createCommand()
          ->select('usr.*, IFNULL(`utr`.`can_view`, 0) can_view, IFNULL(`utr`.`can_edit`, 0) can_edit')
          ->from('spi_user usr')
          ->leftJoin('spi_user_type_right utr', 'utr.type_id=usr.type_id AND utr.page_id = (SELECT id FROM spi_page WHERE code = :code)', array(':code' => safe($_GET, 'model')))
          ->where('usr.auth_token=:token', array(':token' =>$token ))
          ->queryRow();
      }
    }
  }

  public function login($get) {
    if(safe($get, 'login') && safe($get, 'password') || safe($get, 'loginKey')) {
      if($key = safe($get, 'loginKey')) {
        $loginKey = explode(':',base64_decode($key));
        $login = $loginKey[0];
        $password = $loginKey[1];
      } else {
        $login = $get['login'];
        $password = $get['password'];
      }

      $select = 'usr.id, usr.type, usr.type_id, usr.relation_id, usr.login, usr.is_finansist, usr.sex, usr.title, usr.function, usr.first_name, usr.last_name, usr.email, usr.phone, usr.is_active, usr.auth_token, usr.auth_token_created_at, ust.name type_name, usr.is_super_user, usr.is_virtual';
      $this->user = Yii::app()->db->createCommand()
                 ->select($select)
                 ->from('spi_user usr')
                 ->join('spi_user_type ust', 'usr.type_id=ust.id')
                 ->where('login=:user AND usr.password=MD5(:pass)',
                          array( ':user'=>$login, ':pass'=>$password)
                        )
                 ->queryRow();


//      if($this->user['relation_id']) {
//        $table = '';
//        switch($this->user['type']) {
//          case 's':
//            $table = 'spi_school';
//            break;
//          case 'd':
//            $table = 'spi_district';
//            break;
//          case 't':
//            $table = 'spi_performer';
//            break;
//
//        }
//        if($table) {
//          $this->user['relation_name'] = Yii::app()->db->createCommand()
//            ->select('name')
//            ->from($table)
//            ->where('id=:id', array(':id' => $this->user['relation_id']))
//            ->queryScalar();
//        }
//      }



      if($this->user && $this->user['is_active']==1 && $this->user['is_virtual'] !=1 ) {
        $name_table = '';
        $name_field = 'name';
        $relation_name = '';
        switch($this->user['type']) {
          case SCHOOL:
            $name_table = 'spi_school';
            break;
          case DISTRICT:
            $name_table = 'spi_district';
            break;
          case TA:
            $name_field = 'short_name';
            $name_table = 'spi_performer';
            break;
          case SENAT:
            $relation_name = 'Senat';
            break;
          case ADMIN:
            $relation_name = "Administrator";
            break;
          case PA:
            $relation_name = 'Stiftung SPI';
            break;
        }

        if($name_table) {
          $relation_name = Yii::app()->db->createCommand()->select($name_field)->from($name_table)->where('id=:id',
                              array( ':id'=>$this->user['relation_id']))
                            ->queryScalar();
        }
        $this->user['relation_name'] = $relation_name;

        $authToken = $this->user['auth_token'];
        $auth = new Auth($authToken, $this->user);
        if($authToken && $auth->checkToken()) {
          $toUpdate = array( 'auth_token_created_at' => date('Y-m-d H:i:s') );
        } else {
          $authToken = md5($password.'/'.strtotime('now'),false);
          $toUpdate = array( 'auth_token'            => $authToken
                           , 'auth_token_created_at' => date('Y-m-d H:i:s')
                           );
        }
        Yii::app()->db->createCommand()->update( 'spi_user'
                                               , $toUpdate
                                               , 'id=:id'
                                               , array(':id'=>$this->user['id']));
        $this->user['auth_token'] = $authToken;
        $this->user['auth_token_created_at'] = $toUpdate['auth_token_created_at'];

        $rights = array();
        $session_rights = array();
        $rows = Yii::app()->db->createCommand()
          ->select('pag.code, pag.page_code, utr.can_show, utr.can_view, utr.can_edit')
          ->from('spi_page pag')
          ->leftJoin('spi_user_type_right utr', 'utr.page_id = pag.id')
          ->where('utr.type_id=:type_id', array(':type_id'=>$this->user['type_id']))
          ->queryAll();
        foreach($rows as $row) {
          $rights[$row['code']] = array('show' => (int)$row['can_show'], 'view' => (int)$row['can_view'], 'edit' => (int)$row['can_edit']);
          $session_rights[$row['page_code']] = array('show' => (int)$row['can_show'], 'view' => (int)$row['can_view'], 'edit' => (int)$row['can_edit']);
        }
        
        $res = array( 'result'      => true
                    , 'system_code' => 'LOGIN_SUCCESSFUL'
                    , 'code'        => '200'
                    , 'token'       => $authToken
                    , 'rights'      => $rights
                    , 'user'        => $this->user
                    , 'expiredAt'   => strtotime('+'.$this->live.' hour')
                    );
        session_start();
        $_SESSION['login'] = $login;
        $_SESSION['user_type'] = $this->user['type'];
        $_SESSION['rights'] = $session_rights;        

      } else {
        $res = array( 'result'      => false
                    , 'code'        => '401'
                    );
        if($this->user && ($this->user['is_active']==0 || $this->user['is_virtual'] ==1)) {
          $res['system_code'] = 'ERR_USER_DISABLED';
        } else {
          $res['system_code'] = 'ERR_AUTH_FAILED';
        }
      }
    } else {
      $res = array( 'result'      => false
                  , 'system_code' => 'ERR_AUTH_FAILED'
                  , 'code'        => '401'
                  );      
    }
    return $res;

  }
  public function logout(){
    session_start();
    session_destroy();   
  }
  public function getUser() {
    return $this->user;
  }
  public function isActive() {
    return $this->user['is_active'];
  }
  public function checkToken() {
    return (   $this->user['auth_token'] == $this->token
            && $this->user['auth_token_created_at']
            && strtotime($this->user['auth_token_created_at']) > strtotime('-'.$this->live.' hour')
          );
  }
  public function getAuthError() {
    if($this->user['is_active']==0) {
     return array( 'result'      => false
                  , 'system_code' => 'ERR_USER_DISABLED'
                  , 'code'        => '401'
                  );
    }
    if($this->user['auth_token'] != $this->token) {
      return array( 'result'      => false
                  , 'system_code' => 'ERR_INVALID_TOKEN'
                  , 'code'        => '401'
                  );
    } else if (!$this->user['auth_token_created_at'] || strtotime($this->user['auth_token_created_at']) < strtotime('-'.$this->live.' hour')) {
      return array( 'result'      => false
                  , 'system_code' => 'ERR_OUT_OF_DATE'
                  , 'code'        => '401'
                  );
    }
  }
  public function isTokenExists() {
    return $this->user['auth_token'];
  }

  public function checkEmail($email) {
    return Yii::app()->db->createCommand()
      ->select('*')->from('spi_user')
      ->where('email=:email AND is_active=1', array(':email'=>$email))
      ->queryRow();
  }

  public function getRecoveryLink($user) {
    $recToken = md5($user['id']. '/' . $user['login'] . '/' . strtotime('now') . 'spi', false);
    Yii::app() -> db -> createCommand() -> update('spi_user', array(
      'auth_token' => null, 'recovery_token' => $recToken),
      'id=:id', array(':id' => $user['id']));
    return Yii::app()->getBaseUrl(true).'/reset-password?recovery_token=' . $recToken;
  }

  public function checkRecoveryToken($recoveryToken) {
    if(!$recoveryToken)
      return false;
    return Yii::app()->db->createCommand()
      ->select('*')->from('spi_user')
      ->where('recovery_token=:recovery_token', array(':recovery_token'=>$recoveryToken))
      ->queryRow();
  }

  public function updatePassword($user, $newPassword) {
    Yii::app() -> db -> createCommand() -> update('spi_user', array(
      'password' => $newPassword, 'recovery_token' => null),
      'id=:id', array(':id' => $user['id']));
    return true;
  }
}