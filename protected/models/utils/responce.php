<?php
function response($code, $data, $method = '') {
    switch ($code) {
      case '400' :
        header ( "HTTP/1.0 400 Bad Request" );
        break;
      case '401' :
        header ( "HTTP/1.0 401 Unauthorized" );
        break;
      case '403' :
        header ( "HTTP/1.0 403 Forbidden" );
        break;
      case '405' :
        header ( "HTTP/1.0 405 Method not allowed" );
        break;
      case '409' :
        header ( "HTTP/1.0 409 Conflict" );
        break;
    }
    header ( 'Content-Type: application/json' );
    
  
    if (! isset ( $data ['message'] ) && isset ( $data ['system_code'] )) {
      $data ['message'] = responseText ( $data , $method);
    }
    
    echo json_encode ( $data );
    exit ();
  }
  function responseText($data, $method = '') {
    $code = $data ['system_code'];
    $methods = array (
        'get' => 'Select',
        'post' => 'Insert',
        'put' => 'Update',
        'patch' => 'Update',
        'delete' => 'Delete'
    );

    

    $methodsDone = array (
        'get' => 'selected',
        'post' => 'added',
        'put' => 'updated',
        'patch' => 'updated',
        'delete' => 'deleted'
    );

    

    $message = '';
    
    switch ($code) {
      case 'SUCCESSFUL' :
            $message = 'Successfully ' . $methodsDone[$method];
        break;
      case 'ERR_NOT_EXISTS' :
            $message = $methods [$method] . ' failed: This record not exists';
        break;
      case 'ERR_DUPLICATED' :
            $message = $methods [$method] . ' failed: This record already exists';
        break;
      case 'ERR_DUPLICATED_EMAIL' :
            $message = $methods [$method] . ' failed: This email already registered';
        break;
      case 'ERR_DEPENDENT_RECORD' :
            $message = $methods [$method] . ' failed: You cannot delete this entry. There are related records exists: ' . $data ['table'] . '.';
        break;
      case 'ERR_INVALID_QUERY' :
            $message = $methods [$method] . ' failed: Invalid query';
        break;
      case 'ERR_QUERY' :
            $message = $methods [$method] . ' failed: Query error';
        break;
      case 'ERR_PERMISSION' :
            $message = $methods [$method] . ' failed: You are not allowed to perform this operation';
        break;
      case 'ERR_ACCOUNT_PERMISSION' :
            $message = $methods [$method] . ' failed: You are not allowed to perform operation with another account';
        break;
      case 'ERR_MISSED_REQUIRED_PARAMETERS' :
            $message = $methods [$method] . ' failed: A required parameter was not specified for this request';
        break;
      case 'ERR_ID_NOT_SPECIFIED' :
            $message = $methods [$method] . ' failed: Id is not specified';
        break;
      case 'ERR_UPDATE_FORBIDDEN' :
            $message = $methods [$method] . ' failed: You can\'t update this params';
        break;
      default :
            $text = array (
                'LOGIN_SUCCESSFUL' => 'Authentication is successful',
                'ERR_OUT_OF_DATE' => 'Token is out of date',
                'ERR_METHOD_NOT_ALLOWED' => 'Method not allowed',
                'ERR_INVALID_TOKEN' => 'Invalid token',
                'ERR_TOKEN_MISSED' => 'Auth Error',
                'ERR_RECOVERY_EMAIL' => 'Not valid email',
                'ERR_SEND_EMAIL' => 'Email sending error',
                'ERR_ACTIVATION_ACCAUNT' => 'Account activation error',
                'ERR_USER_DISABLED' => 'Your account is disabled',
                'ERR_AUTH_FAILED' => 'Authentication is failed',
                'ERR_ACCOUNT_CREATION' => 'Account creation error',
                'ERR_SERVICE' => 'Invalid service call',
            );
            $message = isset ( $text [$code] ) ? $text [$code] : $code;
    }
    
    return $message;
  }
  
  