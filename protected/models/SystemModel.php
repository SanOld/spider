<?php
class SystemModel extends BaseModel
{
    //TODO: добавить подключение в апиху для юзеров с правами админа
    public function startAllTablesAudit() {
      //TODO: выбираем список всех таблиц, кроме аудита и, если нету записи в сеттингах - добавляем.
      //;
      $query = "SELECT table_name 
                  FROM information_schema.tables 
                 WHERE table_schema= DATABASE() 
                   AND table_name NOT LIKE 'spi_audit%'
                   AND table_name NOT IN(SELECT table_name FROM spi_audit_setting )";
      $tables = Yii::app ()->db->createCommand ( $query )->queryAll ();


      if($tables) {
        $tables_names = array();
        $tables_hashes = array();
        foreach($tables as $table) {
          $tables_names[] = "('{$table['table_name']}')";

          
          $query2 = "SELECT `COLUMN_NAME`, `DATA_TYPE`
                      FROM `INFORMATION_SCHEMA`.`COLUMNS`
                     WHERE `TABLE_NAME`='" . $table['table_name'] . "'";
          $fields = Yii::app ()->db->createCommand ( $query2 )->queryAll ();
          $tables_hashes[] ="'". md5(serialize($fields))."'";
        }


        $insert = 'INSERT INTO spi_audit_setting(table_name) VALUES'.implode(', ',$tables_names);
        Yii::app()->db
                  ->createCommand($insert)
                  ->execute();
      }
    }
    public function updateTablesAudit() {
      $operations =  array( array('code' => 'INS', 'from' => 'new', 'when' => 'AFTER INSERT', 'message' => 'Created', 'system_code' => 'insert')
                          , array('code' => 'DEL', 'from' => 'old', 'when' => 'AFTER DELETE', 'message' => 'Deleted', 'system_code' => 'delete')
                          , array('code' => 'UPD', 'from' => 'new', 'when' => 'AFTER UPDATE', 'message' => 'Changed', 'system_code' => 'update')
                          );
      $tables = Yii::app()->db
                          ->createCommand()
                          ->select('tbl.*')
                          ->from('spi_audit_setting tbl')
                          ->where(' is_enabled_audit = 1 ', array())
                          ->queryAll();
      $arr = array();
      foreach($tables as $table) {
        $tableName = $table['table_name'];
        $query = "SELECT `COLUMN_NAME`, `DATA_TYPE`
                    FROM `INFORMATION_SCHEMA`.`COLUMNS`
                   WHERE `TABLE_NAME`='" . $tableName . "'";
        $fields = Yii::app ()->db->createCommand ( $query )->queryAll ();

        echo 1111;
        $arr['one'] = true;
        $hash = md5(serialize($fields));
        if($hash == $table['hash']) {
          continue;
        }
        $arr['two'] = true;
        foreach($operations as $operation) {
          
          $insert = "\n\n";
          $fieldsCounter = array(); //костыль от дублирования столбцов
          foreach($fields as $field) {
            $fieldName = $field['COLUMN_NAME'];



            if($operation['code'] != 'UPD') {
              $insert .= "INSERT INTO spi_audit_data(event_id,column_name,{$operation['from']}_value) VALUES(ev_id,'{$fieldName}',{$operation['from']}.{$fieldName});\n";
            } else {
              if (!$fieldsCounter[$fieldName]){
                $insert .= "
                        IF  ( old.{$fieldName}<>new.{$fieldName} OR  (ISNULL(old.{$fieldName}) AND new.{$fieldName}<>'') )  THEN
                         INSERT INTO spi_audit_data(event_id,column_name,old_value,new_value) VALUES(ev_id,'{$fieldName}',old.{$fieldName},new.{$fieldName});
                        END IF;\n";
                $fieldsCounter[$fieldName] = 1;
              }
            }
          }

          $trigger = "
            DROP TRIGGER IF EXISTS `{$tableName}_A{$operation['code']}`;
            DELIMITER $$
            CREATE
                DEFINER = CURRENT_USER 
                TRIGGER `{$tableName}_A{$operation['code']}` {$operation['when']} ON `{$tableName}` 
                FOR EACH ROW BEGIN    
                DECLARE ev_id INT; 	     
                    IF check_audit('{$tableName}')=1 THEN	
                  INSERT INTO spi_audit_event(table_name, record_id,event_type,user_id)
                  VALUES('{$tableName}',{$operation['from']}.id,'{$operation['code']}',@user_id);
                      SELECT LAST_INSERT_ID() INTO ev_id;
                      {$insert}
                END IF;
            END
            \n\n";



     

          Yii::app()->db
                    ->createCommand($trigger)
                    ->execute();
        }
$arr['three'] = true;
        Yii::app ()->db->createCommand ()->update ( 'spi_audit_setting', array('hash' => $hash), 'id=:id', array (':id' => $table['id'] ));
      }
//      header ( 'Content-Type: application/json' );
//      echo json_encode ( array('results' => 'done') );
      echo $trigger;
      exit ();
    }

    public function deleteTablesAudit() {
      $operations =  array( array('code' => 'INS', 'from' => 'new', 'when' => 'AFTER INSERT', 'message' => 'Created', 'system_code' => 'insert')
                          , array('code' => 'DEL', 'from' => 'old', 'when' => 'AFTER DELETE', 'message' => 'Deleted', 'system_code' => 'delete')
                          , array('code' => 'UPD', 'from' => 'new', 'when' => 'AFTER UPDATE', 'message' => 'Changed', 'system_code' => 'update')
                          );
      $tables = Yii::app()->db
                          ->createCommand()
                          ->select('tbl.*')
                          ->from('spi_audit_setting tbl')
                          ->where(' is_enabled_audit = 1 ', array())
                          ->queryAll();

      foreach($tables as $table) {
        $tableName = $table['table_name'];

        foreach($operations as $operation) {

          $trigger = "DROP TRIGGER IF EXISTS `{$tableName}_A{$operation['code']}`;";

          Yii::app()->db
                    ->createCommand($trigger)
                    ->execute();
        }
        Yii::app ()->db->createCommand ()->update ( 'spi_audit_setting', array('hash' => ''), 'id=:id', array (':id' => $table['id'] ));
      }

      header ( 'Content-Type: application/json' );
      echo json_encode ( array('results' => 'done') );
      exit ();
    }

//    public function execute() {
//      $headers = getallheaders ();
//      if (isset ( $headers ['Authorization'] ) && $headers ['Authorization']) {
//        $type = isset($headers['API-Type'])?$headers['API-Type']:'';
//        $auth = new Auth($headers['Authorization'], $type);
//      
//        if ($auth->checkToken()) {
//          $method = strtolower ( $_SERVER ['REQUEST_METHOD'] );
//          if ($method && $method == 'put') {
//            parse_str ( file_get_contents ( "php://input" ), $post_vars );
//            $jsonRequest = '';
//            switch ($post_vars['method']) {
//              case 'updateTriggers' : $this->updateTablesAudit();
//                break;
//              default: 
//                header ( "HTTP/1.0 405 Method not allowed" );
//                header ( 'Content-Type: application/json' );
//                echo json_encode ( array('results' => 'canceled') );
//                exit ();
//            }
//          }
//        }
//      }
//      header ( "HTTP/1.0 403 Forbidden" );
//      exit ();
//    }
    
//    public function __construct() {
//      $this->execute();
//      exit();
//    }

    public function updateReuest() {

      $Request = CActiveRecord::model('Request');
      $Request->user = $this->user;
      $request_ids = Yii::app()->db->createCommand()->select('id')->from('spi_request')->where('1=1')->queryAll();
      foreach ($request_ids as $key=>$value) {
        $Request->statusUpdate($value['id']);
        
      }

      header ( 'Content-Type: application/json' );
        echo json_encode ( array('results' => 'done') );
        exit ();

    }
}
