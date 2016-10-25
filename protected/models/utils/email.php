<?php
require_once ('responce.php');

class Email {
  static $from = 'info@spider.com';

  static function doRecovery($user, $recoveryLink) {
    return self::prepareMessage('send_password', array( '{NAME}' => $user['first_name'] . ' '. $user['last_name']
                                                           , '{LINK}' => $recoveryLink
                                                           ), $user['email']);

//    $message = 'Dear ' . $user['first_name'] . ' '. $user['last_name'] . '!';
//    $message .= '<br><br>We have received request for recovery your account password.';
//    $message .= '<br>If you have sent it, please follow this <a target="_blank" href="'.$recoveryLink.'">link</a>, for update your password.';

  }

  static function sendMessageByTemplate($template, $params, $email) {
    $emailParams = array();
    foreach($params as $key => $val) {
      $emailParams['{'.strtoupper($key).'}'] = $val;
    }
    return self::prepareMessage($template, $emailParams, $email, false);
  }
  static function doWelcome($result, $password) {

    $table = 'spi_user';
    $select_all = "CONCAT(tbl.last_name, ', ', tbl.first_name) name, IF(tbl.is_active = 1, 'Aktiv', 'Nicht aktiv') status_name, IF(tbl.type = 't' AND tbl.is_finansist, CONCAT(ust.name, ' (F)'), ust.name) type_name, tbl.* ";
    $command = Yii::app() -> db -> createCommand() -> select($select_all) -> from($table . ' tbl');
    $command -> join('spi_user_type ust', 'tbl.type_id = ust.id');
    $command -> where("tbl.id = :id", array(':id' => $result['id']));
    $newUser = $command -> queryRow();
    
      return self::prepareMessage('send_account_data', array(
        '{NAME}'            => $newUser['first_name'] . ' '. $newUser['last_name'],
        '{SITE_URL}'        => Yii::app()->getBaseUrl(true),
        '{LOGIN}'           => $newUser['login'],
        '{PASSWORD}'        => $password,
        '{BENUTZERROLLEN}'  => $newUser['type_name'],
      ), $newUser['email'], false);



//    $message = 'Dear ' . $user['first_name'] . ' '. $user['last_name'] . '!';
//    $message .= '<br><br>You get access to <a target="_blank" href="'.Yii::app()->getBaseUrl(true).'">SPIder</a>.';
//    $message .= '<br>Login: '.$user['login'];
//    $message .= '<br>Password: '.$user['password'];
//    return self::send($user['email'], self::$from, 'Welcome to SPIder', $message, '', false);
  }

  static function doUpdatePassword($user, $newPassword) {
    $message = 'Dear ' . $user['first_name'] . ' '. $user['last_name'] . '!';
    $message .= '<br><br>Your password was been changed.';
    $message .= '<br>Login: '.$user['login'];
    $message .= '<br>New password: '.$newPassword;
    return self::send($user['email'], self::$from, 'SPIder: Password changed', $message, '', false);
  }

  static function prepareMessage($code, $params, $email, $showResults = true) {
    if($row = Yii::app() -> db -> createCommand()
              -> select('text, subject') -> from('spi_email_template')
              -> where('system_come=:system_come ', array(':system_come' => $code))
              ->queryRow()) {
      $data = array();
      $placeholders = array();
      foreach($params as $key=>$val) {
        $data[] = $val;
        $placeholders[] = $key;
      }
      $message = str_replace($placeholders, $data, $row['text']);
      $subject = str_replace($placeholders, $data, $row['subject']);
      return self::send($email, self::$from, $subject, $message, '', $showResults);
    }
    return false;
  }

  static function send($to, $from, $subject, $message, $frwd = '', $showResults = true, $addAttachment = false) {
    if(Yii::app()->params['disable_emails']) {
      return false;
    }
    $mail = Yii::app() -> Smtpmail;
    if ($addAttachment && is_array($addAttachment)) {
      foreach($addAttachment as $value){
        $mail -> addAttachment($value);
      }
    }
    $mail -> SetFrom($from, 'SPIder info');//$_SERVER['HTTP_HOST']
    $mail -> Subject = $subject;
    $mail -> MsgHTML($message);
    $mail -> AddAddress($to, "");
    $res = $mail -> Send();
    if($showResults) {
      if(!$res) {
        response('409', array(
          'result' => false,
          'system_code' => 'ERR_SEND_EMAIL',
          'Error' => array(
            $mail -> ErrorInfo
          )
        ));
      } else {
        if($frwd!=''){
          header("Location:".$frwd); /* Redirect browser */
          exit();
        }
        response('200', array(
          'result' => true,
          'silent' => true,
          'message' => 'E-Mail successfully sent',
        ));
      }
    } else {
      return array( 'result'        => $res
                  , 'from'          => $from
                  , 'to'            => $to
                  , 'subject'       => $subject
                  , 'message'       => $message
                  , 'showResults'   => $showResults
                  , 'addAttachment' => $addAttachment
                  );
    }
  }
}