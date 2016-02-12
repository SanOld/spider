<?php
require_once ('responce.php');
  
class Email {
  static $from = 'info@spider.com';

  static function doRecovery($user, $recoveryLink) {
    $message = 'Dear ' . $user['first_name'] . ' '. $user['last_name'] . '!';
    $message .= '<br>We have received request for recovery your account password..';
    $message .= '<br>If you have sent it, please follow this '.$recoveryLink.', for update your password.';
    return self::send($user['email'], self::$from, 'Recovery confirmation from SPIder', $message);
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