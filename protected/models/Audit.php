<?php
require_once ('utils/utils.php');
//require_once ('utils/responce.php');

class Audit extends BaseModel {
  public $table = 'spi_audit_event';
  public $post = array();
  public $operations = array('INS' => 'Hinzugefügt', 'UPD' => 'Bearbeitet', 'DEL' => 'Gelöscht');
  public $select_all = ' tbl.*, usr.first_name, usr.last_name';
  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    $command->leftJoin('spi_user usr', 'usr.id=tbl.user_id ');
    $where = '1=1 AND user_id IS NOT NULL';
   
    $conditions = array();

    if ($where) {
      $command -> where($where, $conditions);
    }
    
    $command->andWhere('(SELECT 1 FROM spi_audit_data aud WHERE aud.event_id=tbl.id LIMIT 1) IS NOT NULL');
    return $command;
  }
  protected function doAfterSelect($result) {
    foreach($result['result'] as &$row) {
      $row['data'] = Yii::app() -> db -> createCommand() 
                                      -> select('*') 
                                      -> from('spi_audit_data aud')
                                      -> where('aud.event_id=:id', array(':id' => $row['id']))
                                      -> andWhere('(aud.old_value<>"" AND aud.old_value IS NOT NULL) OR (aud.new_value<>"" AND aud.new_value IS NOT NULL)')  
                                      -> queryAll();
      foreach ($row['data'] as &$data){
        if($data['column_name'] == "password"){
          $data['old_value'] = $data['new_value'] = "* * * * * * * *";
        };
      };
      
      $table_code = str_replace('spi_', '', $row['table_name']);
      $row['table_name'] = Yii::app() -> db -> createCommand() 
                                      -> select('name') 
                                      -> from('spi_page pag')
                                      -> where('pag.code=:code', array(':code' => $table_code))
                                      -> queryScalar();
      $row['table_name'] = $row['table_name'] ? $row['table_name'] : $table_code;
      
      if($table_code == 'request') {
        $row['main_code'] = Yii::app() -> db -> createCommand() 
                                      -> select('CONCAT(prj.code, "(", req.year ,")")') 
                                      -> from('spi_request req')
                                      -> join('spi_project prj', 'prj.id=req.project_id ')
                                      -> where('req.id=:record_id', array(':record_id' => $row['record_id']))
                                      -> queryScalar();
      } elseif ($table_code == 'request_goal') {
        $row['main_code'] = Yii::app() -> db -> createCommand() 
                                      -> select('CONCAT(prj.code, "(", req.year ,")")') 
                                      -> from('spi_'.$table_code.' tbl')
                                      -> join('spi_request_school_goal scg', 'scg.id=tbl.request_school_goal_id ')
                                      -> join('spi_request req', 'req.id=scg.request_id ')
                                      -> join('spi_project prj', 'prj.id=req.project_id ')
                                      -> where('tbl.id=:record_id', array(':record_id' => $row['record_id']))
                                      -> queryScalar();
      } elseif (strrpos($table_code, 'request') !== false) {
        $row['main_code'] = Yii::app() -> db -> createCommand() 
                                      -> select('CONCAT(prj.code, "(", req.year ,")")') 
                                      -> from('spi_'.$table_code.' tbl')
                                      -> join('spi_request req', 'req.id=tbl.request_id ')
                                      -> join('spi_project prj', 'prj.id=req.project_id ')
                                      -> where('tbl.id=:record_id', array(':record_id' => $row['record_id']))
                                      -> queryScalar();
      } elseif (strrpos($table_code, 'performer') !== false) {
        $row['main_code'] = Yii::app() -> db -> createCommand() 
                                      -> select('short_name') 
                                      -> from('spi_performer tbl')
                                      -> where('tbl.id=:record_id', array(':record_id' => $row['record_id']))
                                      -> queryScalar();
      } elseif (strrpos($table_code, 'bank_details') !== false) {
        $row['main_code'] = Yii::app() -> db -> createCommand() 
                                      -> select('prf.short_name') 
                                      -> from('spi_bank_details tbl')
                                      -> join('spi_performer prf', 'prf.id=tbl.performer_id ')
                                      -> where('tbl.id=:record_id', array(':record_id' => $row['record_id']))
                                      -> queryScalar();
      } else {
        $row['main_code'] = '';
      }

      
      $row['user_name'] = $row['first_name'].' '.$row['last_name'];
      $row['operation_name'] = $this->operations[$row['event_type']];
      $row['date_formated'] = date('d.m.y H:i:s',strtotime($row['event_date']));
    }
    return $result;
  }  

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);

    if(safe($params, 'EVENT_TYPE')) {
      $command->andWhere('tbl.event_type = :et', array(':et' => safe($params, 'EVENT_TYPE')));
    }
    
    if(safe($params, 'EVENT_DATE')) {
      $command->andWhere('tbl.event_date LIKE "'.safe($params, 'EVENT_DATE').'%" ');
    }
    
    $like_field_list = array('usr.first_name', 'usr.last_name', 'tbl.record_id');
    if(safe($params, 'TABLE_NAME')) {
      switch (safe($params, 'TABLE_NAME')) {
        case 'request':
          if(safe($params, 'REQUEST_CODE') || safe($params, 'REQUEST_YEAR')) {
            $row['tables'] = Yii::app() -> db -> createCommand() 
                                        -> select('table_name') 
                                        -> from('spi_audit_event tbl')
                                        -> group('table_name')
                                        -> where('table_name LIKE :code ', array(':code' => '%request%'))
                                        -> queryAll();
            $query = '( 1!=1 ';
            foreach ($row['tables'] as $table_data) {
              $table = $table_data['table_name'];
              
              
              if($table == 'spi_request') {
                $com = Yii::app() -> db -> createCommand()
                                        -> select('req.id') 
                                        -> from('spi_request req')
                                        -> join('spi_project prj', 'prj.id=req.project_id ')
                                        -> where('1=1');
                                        
                if(safe($params, 'REQUEST_CODE')) {
                  $com->andWhere('prj.code LIKE :code', array(':code' => '%'.safe($params, 'REQUEST_CODE').'%'));
                }
                if(safe($params, 'REQUEST_YEAR')) {
                  $com->andWhere('req.year=:year', array(':year' => safe($params, 'REQUEST_YEAR')));
                }
                $res = $com -> queryAll();
                
                if($res) {
                  $ids = array();
                  foreach ($res as $resRow) {
                    $ids[] = $resRow['id'];
                  }
                  $query .= "\n OR (tbl.table_name = 'spi_request' AND tbl.record_id IN(".  implode(', ', $ids).'))';
                } else {
                  //request is not exists
                  $query = "(1<>1";
                  break;
                }
              } elseif($table == 'spi_request_goal') {
                try {
                  $com = Yii::app() -> db -> createCommand()
                                          -> select('tbl.id') 
                                          -> from($table.' tbl')
                                          -> join('spi_request_school_goal scg', 'scg.id=tbl.request_school_goal_id')
                                          -> join('spi_request req', 'req.id=scg.request_id ')
                                          -> join('spi_project prj', 'prj.id=req.project_id ')
                                          -> where('1=1');

                  if(safe($params, 'REQUEST_CODE')) {
                    $com->andWhere('prj.code LIKE :code', array(':code' => '%'.safe($params, 'REQUEST_CODE').'%'));
                  }
                  if(safe($params, 'REQUEST_YEAR')) {
                    $com->andWhere('req.year=:year', array(':year' => safe($params, 'REQUEST_YEAR')));
                  }
                  $res = $com -> queryAll();
                  if($res) {
                    $ids = array();
                    foreach ($res as $resRow) {
                      $ids[] = $resRow['id'];
                    }
                    $query .= "\n OR (tbl.table_name = '".$table."' AND tbl.record_id IN(".  implode(', ', $ids).'))';
                  }
                } catch (Exception $e) {
                  //skip
                }
              } else {
                try {
                  $com = Yii::app() -> db -> createCommand() 
                                          -> select('tbl.id') 
                                          -> from($table.' tbl')
                                          -> join('spi_request req', 'req.id=tbl.request_id ')
                                          -> join('spi_project prj', 'prj.id=req.project_id ')
                                          -> where('1=1');
                                          
                  if(safe($params, 'REQUEST_CODE')) {
                    $com->andWhere('prj.code LIKE :code', array(':code' => '%'.safe($params, 'REQUEST_CODE').'%'));
                  }
                  if(safe($params, 'REQUEST_YEAR')) {
                    $com->andWhere('req.year=:year', array(':year' => safe($params, 'REQUEST_YEAR')));
                  }
                  $res = $com -> queryAll();
                  if($res) {
                    $ids = array();
                    foreach ($res as $resRow) {
                      $ids[] = $resRow['id'];
                    }
                    $query .= "\n OR (tbl.table_name = '".$table."' AND tbl.record_id IN(".  implode(', ', $ids).'))';
                  }
                } catch (Exception $e) {
                  //skip
                }
              }
              
            }
            $query .= ')';
//            echo($query);die;
            $command->andWhere($query);
          } else {
            $command->andWhere('tbl.table_name LIKE( CONCAT(:tn,"%") ) ', array(':tn' => 'spi_'.safe($params, 'TABLE_NAME')));
          }
//          $like_field_list[] = 'request_code';
          break;
        case 'performer': 
          
          if(safe($params, 'PERFORMER_NAME')) {
            $query = '( 1!=1 ';
            $res = Yii::app() -> db -> createCommand()
                                    -> select('prf.id') 
                                    -> from('spi_performer prf')
                                    -> where('name LIKE(:name) OR short_name LIKE(:name) OR email LIKE(:name)', array(':name' => '%'.safe($params, 'PERFORMER_NAME').'%'))
                                    -> queryAll();
            if($res) {
              $ids = array();
              foreach ($res as $resRow) {
                $ids[] = $resRow['id'];
              }
              $query .= "\n OR (tbl.table_name = 'spi_performer' AND tbl.record_id IN(".  implode(', ', $ids).'))';
              $res = Yii::app() -> db -> createCommand()
                                      -> select('tbl.id') 
                                      -> from('spi_bank_details tbl')
                                      -> join('spi_performer prf', 'prf.id=tbl.performer_id ')
                                      -> where('prf.name LIKE(:name) OR prf.short_name LIKE(:name) OR prf.email LIKE(:name)', array(':name' => '%'.safe($params, 'PERFORMER_NAME').'%'))
                                      -> queryAll();
              if($res) {
                $ids = array();
                foreach ($res as $resRow) {
                  $ids[] = $resRow['id'];
                }
                $query .= "\n OR (tbl.table_name = 'spi_bank_details' AND tbl.record_id IN(".  implode(', ', $ids).'))';
              }
            } else {
              //performer is not exists
              $query = "(1<>1";
            }
            
            $query .= ')';
//            echo($query);die;
            $command->andWhere($query);
          } else {
            $command->andWhere('( tbl.table_name = :tn OR tbl.table_name = :tn2)', array(':tn' => 'spi_'.safe($params, 'TABLE_NAME'), ':tn2' => 'spi_bank_details'));
          }
          break;
        default :$command->andWhere('tbl.table_name = :tn', array(':tn' => 'spi_'.safe($params, 'TABLE_NAME')));
      }
      
    }
    if(safe($params, 'USER_NAME')) {
      $command = $this->setLikeWhere($command, $like_field_list, safe($params, 'USER_NAME'));
    }
    
    
    return $command;
  }
  
  protected function checkPermission($user, $action, $data) {
    switch ($action) {
      case ACTION_SELECT:
        return $user['can_view'];
      case ACTION_UPDATE:
      case ACTION_INSERT:
      case ACTION_DELETE:
        return false;
    }
    return false;
  }

}
