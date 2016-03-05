<?php
require_once ('responce.php');
  
class Email {
  static $from = 'info@spider.com';

  static function doRecovery($user, $recoveryLink) {
    $message = 'Dear ' . $user['first_name'] . ' '. $user['last_name'] . '!';
    $message .= '<br><br>We have received request for recovery your account password.';
    $message .= '<br>If you have sent it, please follow this <a target="_blank" href="'.$recoveryLink.'">link</a>, for update your password.';
    return self::send($user['email'], self::$from, 'Recovery confirmation from SPIder', $message, '', false);
  }

  static function doWelcome($user) {
    $message = 'Dear ' . $user['first_name'] . ' '. $user['last_name'] . '!';
    $message .= '<br><br>You get access to <a target="_blank" href="'.Yii::app()->getBaseUrl(true).'">SPIder</a>.';
    $message .= '<br>Login: '.$user['login'];
    $message .= '<br>Password: '.$user['password'];
    return self::send($user['email'], self::$from, 'Welcome to SPIder', $message, '', false);
  }

  static function doUpdatePassword($user, $newPassword) {
    $message = 'Dear ' . $user['first_name'] . ' '. $user['last_name'] . '!';
    $message .= '<br><br>Your password was been changed.';
    $message .= '<br>Login: '.$user['login'];
    $message .= '<br>New password: '.$newPassword;
    return self::send($user['email'], self::$from, 'SPIder: Password changed', $message, '', false);
  }

  static function send($to, $from, $subject, $message, $frwd = '', $showResults = true, $addAttachment = false) {
    $mail = Yii::app() -> Smtpmail;
    if ($addAttachment && is_array($addAttachment)) {
      foreach($addAttachment as $value){
        $mail -> addAttachment($value);
      }
    }
    $mail -> SetFrom($from, $_SERVER['HTTP_HOST']);
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
          'message' => 'Email successfully sent',
        ));
      }
    } else {
      return $res;
    }
  }
}