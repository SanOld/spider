<?php
require_once ('utils/utils.php');
require_once ('utils/email.php');
use  yii\helpers\ArrayHelper ;


class Request extends BaseModel {
  public $table = 'spi_request';
  public $post = array();
  public $copy = false;
  public $school_concepts = array();
  public $finance_plan = array();
  public $school_goals = array();
  public $lock = false;
  public $select_all = "tbl.*
                      , prf.short_name performer_name
                      , prf.is_checked performer_is_checked
                      , rqs.name status_name
                      , rqs.code status_code
                      , prj.code code
                      , dst.id district_id
                      , IF(prj.type_id = 3, 1, 0) is_bonus_project
                      , prj.id project_id
                      , fns.programm
                      ,(SELECT scl.name FROM spi_project_school prs LEFT JOIN spi_school scl ON prs.school_id=scl.id WHERE prs.project_id=prj.id ORDER BY scl.name LIMIT 1) AS `school_name`";

  public $paPriority = array('in_progress' => 1, 'rejected' => 2, 'unfinished' => 3, 'accepted' => 4 );
  public $taPriority = array('rejected' => 1, 'unfinished' => 2, 'in_progress' => 3, 'accepted' => 4 );

  protected function getCommand() {
    if(safe($_GET, 'list') == 'year') {
      $command = Yii::app() -> db -> createCommand()->select('year')->from($this -> table . ' tbl')->group('year');
      $command -> join('spi_project prj','tbl.project_id = prj.id' );
    } elseif (isset($_GET['id'])){
      $this -> select_all = "tbl.*
                            , prj.id project_id
                            , prj.code code
                            , IF(prj.type_id = 3, 1, 0) is_bonus_project

                            , rqs.code status_code

                            , prf.id performer_id
                            , prf.is_checked performer_is_checked
                            , CONCAT( 'Überpüft von ',
                                (SELECT CONCAT (u.first_name, ' ', u.last_name) name
                                   FROM spi_user u
                                  WHERE u.id = prf.checked_by), ' ',
                                  DATE_FORMAT(prf.checked_date,'%d.%m.%Y')

                              ) performer_checked_by
                            , prf.short_name performer_name
                            , prf.name performer_long_name
                            , prf.address performer_address
                            , prf.plz performer_plz
                            , prf.city performer_city
                            , prf.homepage performer_homepage
                            , prf.phone performer_phone
                            , prf.fax performer_fax
                            , prf.email performer_email
                            , prf_user.function performer_contact_function
                            , CONCAT(IF(prf_user.sex = 1, 'Herr', 'Frau' ), ' ' , prf_user.first_name, ' ', prf_user.last_name) performer_contact

                            , dst.id district_id
                            , dst.name district_name
                            , dst.address district_address
                            , dst.plz district_plz
                            , dst.city district_city
                            , dst.phone district_phone
                            , dst.fax district_fax
                            , dst.email district_email
                            , dst.homepage district_homepage
                            , CONCAT(IF(user.sex = 1, 'Herr', 'Frau' ), ' ' , user.first_name, ' ', user.last_name) district_contact

                            ";
      $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
      if($this->user['type'] == 't'){
        $command -> join( 'spi_request_status rqs', 'tbl.status_id_ta        = rqs.id' );
      } else {
        $command -> join( 'spi_request_status rqs', 'tbl.status_id           = rqs.id' );
      }
      $command -> join(     'spi_performer prf',          'tbl.performer_id        = prf.id' );
      $command -> leftJoin( 'spi_user prf_user',          'prf_user.id             = prf.representative_user_id' );
      $command -> join(     'spi_project prj',            'tbl.project_id          = prj.id' );
      $command -> leftJoin( 'spi_district dst',           'dst.id                  = prj.district_id' );
      $command -> leftJoin( 'spi_user user',              'user.id                 = dst.contact_id' );
      $command -> where(' 1=1 ', array());

    } else {
      $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
      if($this->user['type'] == 't'){
        $command -> join( 'spi_request_status rqs', 'tbl.status_id_ta      = rqs.id' );
      } else {
        $command -> join( 'spi_request_status rqs', 'tbl.status_id         = rqs.id' );
      }
      $command -> leftJoin( 'spi_performer prf',  'tbl.performer_id        = prf.id' );
      $command -> join( 'spi_project prj',        'tbl.project_id          = prj.id' );
      $command -> join( 'spi_district dst',        'prj.district_id        = dst.id' );
      $command -> join( 'spi_finance_source fns', 'prj.programm_id         = fns.id' );
      $command -> where(' 1=1 ', array());

    }
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'PERFORMER_ID')) {
      $command -> andWhere('prf.id = :performer_id', array(':performer_id' => $params['PERFORMER_ID']));
    }
    if(safe($params, 'PROJECT_TYPE_ID')) {
      $command -> andWhere('prj.type_id = :type_id', array(':type_id' => $params['PROJECT_TYPE_ID']));
    }

    if(safe($params, 'PROJECT_IS_OLD') && safe($params, 'YEAR')) {
      $command -> andWhere('prj.is_old = :is_old OR tbl.year = :year', array(':is_old' => $params['PROJECT_IS_OLD'], ':year' => $params['YEAR']));
      $command -> group(array('prj.code'));
    } elseif (!safe($params, 'PROJECT_IS_OLD') && safe($params, 'YEAR')) {
      $command -> andWhere('tbl.year = :year', array(':year' => $params['YEAR']));
    }

    if(safe($params, 'SCHOOL_TYPE_ID')) {
      $command -> andWhere('prj.school_type_id = :school_type_id', array(':school_type_id' => $params['SCHOOL_TYPE_ID']));
    }
    if(safe($params, 'PROJECT_ID')) {
      $command -> andWhere('prj.id = :project_id', array(':project_id' => $params['PROJECT_ID']));
    }
    if(safe($params, 'GROUP')) {
      $command -> group('tbl.year');
    }
    if(safe($params, 'GROUP_CODES')) {
      $command -> group('prj.code');
    }
    if(safe($params, 'PROJECT_CODE')) {
      $command -> andWhere('prj.code = :project_code', array(':project_code' => $params['PROJECT_CODE']));
    }
    if(safe($params, 'STATUS_ID')) {
      if(!is_int($params['STATUS_ID'])) {
        $values = explode(',', $params['STATUS_ID']);
      } else {
        $values = array($params['STATUS_ID']);
      }
      $command -> andWhere(array('in', 'rqs.id', $values));
    }
    if(safe($params, 'PROJECT_IDS')) {
      if(!is_int($params['PROJECT_IDS'])) {
        $values = explode(',', $params['PROJECT_IDS']);
      } else {
        $values = array($params['PROJECT_IDS']);
      }
      $command -> andWhere(array('in', 'tbl.project_id', $values));   
    }
    if (isset($params['SCHOOL_ID'])) {
      $command->leftJoin('spi_project_school sps', 'sps.project_id=tbl.project_id');      
      $command-> join( 'spi_school scl', 'sps.school_id = scl.id' );
      $command -> andWhere("scl.id = :school_id", array(':school_id' => $params['SCHOOL_ID']));
    }
    if (safe($params,'STATUSES')) {
      $string = '';
      if(!is_int($params['STATUSES'])) {
        $values = explode(',', $params['STATUSES']);
        unset($values[sizeof($values)-1]);
      };
      foreach ($values as $key){
        $element = explode('_', $key);
        $page = '';
        if(sizeof($element) > 2){          
          $status = $element[0].'_'.$element[1];
          $page = 'status_'.$element[2];
        }else{
          $status = $element[0];
          $page = 'status_'.$element[1];
        }
        if($page == 'status_finance' && $this->user['type'] == SCHOOL){
          $string .= "(tbl.".$page." = '".$status."' AND prj.type_id = 3) OR ";
        }else{
          $string .= "tbl.".$page." = '".$status."' OR ";
        }
      };
      $string = substr($string,0,-4);
      $command->andWhere($string);
    };
    if (safe($params, 'CODE')) {
      if($this->user['type'] == TA){        
        $command->andWhere("prj.code = :code", array(':code' => $params['CODE']));
      }else{        
        $command = $this->setLikeWhere($command, array('prj.code'), safe($params, 'CODE'));
      }
    }
    $command = $this->setWhereByRole($command);

    return $command;
  }

  protected function setWhereByRole($command) {
    switch($this->user['type']) {
      case SCHOOL:
        $command->join('spi_project_school sps', 'sps.project_id=tbl.project_id');
        $command->andWhere("sps.school_id = :school_id", array(':school_id' => $this->user['relation_id']));
        break;
      case DISTRICT:
        $command->andWhere("prj.district_id = :district_id", array(':district_id' => $this->user['relation_id']));
        break;
      case TA:
        $command->andWhere("prj.performer_id = :performer_id", array(':performer_id' => $this->user['relation_id']));
        break;
    }
    return $command;
  }

  protected function calcResults($result) {
    if(safe($_GET, 'list') == 'year') {
      foreach($result['result'] as &$row) {
        $row = (int)$row['year'];
      }
//      if(!in_array(date("Y"), $result['result'])) {
//        array_push($result['result'], (int)date("Y"));
//      }
    } else {
      foreach($result['result'] as &$row) {

        if($row['start_date']   == '0000-00-00'){ $row['start_date']  = ''; }
        if($row['due_date']     == '0000-00-00'){ $row['due_date']    = ''; }
        if($row['last_change']  == '0000-00-00'){ $row['last_change'] = ''; }
        if($row['end_fill']     == '0000-00-00'){ $row['end_fill']    = ''; }

        if($this->user['type'] == 't'){
          $row['status_goal'] = $row['status_goal_ta'];
          $row['status_concept'] = $row['status_concept_ta'] ;
        }

        $row['is_action_required'] = $this->isActionRequired(array(
                                                                  $row['status_goal']
                                                                  ,$row['status_concept']
                                                                  ,$row['status_finance']
        ));

      }
    }
    return $result;
  }

  protected function calcStatusId($row, $userType) {

    if (in_array($row['status_id'], array('2', '4', '5'))) {
      $result = $row['status_id'];
      return $result;
    }

//    if($row['status_id'] == '2' || ){
//     $result = '2' ;
//     return $result;
//    }

    switch($userType){
      case 'a':
      case 'p':        
        $result = $row['status_id'];
          if(          $row['status_concept']   === 'in_progress' 
                    || $row['status_finance']   === 'in_progress'
                    || $row['status_goal']      === 'in_progress'){
            $result = '3'; //in_progress
          } else if(   $row['status_concept']   === 'accepted' 
                    && $row['status_finance']   === 'accepted' 
                    && $row['status_goal']      === 'accepted' 
                    && $row['status_id']        != '4' 
                    && $row['status_id']        != '5' 
                    && $row['status_id']        != '2'){
            $result = '3'; //in_progress
          } else if(   ($row['status_concept']  !== 'in_progress' && $row['status_concept'] !== 'unfinished') 
                    && ($row['status_finance']  !== 'in_progress' && $row['status_finance'] !== 'unfinished') 
                    && ($row['status_goal']     !== 'in_progress' && $row['status_goal']    !== 'unfinished')){
            $result = '6';  //wait
          }else {
            $result = '1'; //open
          }
        break;
        
      case 't':        
        $result = $row['status_id_ta'];
          if(          $row['status_concept_ta'] === 'rejected' 
                    || $row['status_finance']    === 'rejected' 
                    || $row['status_goal_ta']    === 'rejected'){
            $result = '3'; //in_progress
          }else if ((  $row['status_concept']    === 'accepted' 
                    && $row['status_finance']    === 'accepted' 
                    && $row['status_goal']       === 'accepted' 
                    && $row['status_id']         != '4' 
                    && $row['status_id']         != '5' 
                    && $row['status_id']         != '2') 
                    ||
                   (   $row['status_concept_ta'] !== 'unfinished' 
                    && $row['status_finance']    !== 'unfinished'
                    && $row['status_goal_ta']    !== 'unfinished')){
            $result = '6'; //wait
          }else{
            $result = '1'; //open
          } 
        break;
    }
    
    return $result;
  }
  protected function calcConceptStatus($ID, $userType) {
    $statusPriority = in_array($userType, array('a', 'p')) ? $this->paPriority : $this->taPriority;
    $RequestSchoolConcept = CActiveRecord::model('RequestSchoolConcept');
    $RequestSchoolConcept->user = $this->user;
    return $RequestSchoolConcept->getCommonStatus($ID, $statusPriority);
  }
  protected function calcGoalsStatus($ID, $userType) {
    $resultStatus = 'unfinished';
     if($userType == 'a'){
       $priority = $this->paPriority;
     } else {
       $priority = $this->taPriority;
     }
    $RequestSchoolGoal = CActiveRecord::model('RequestSchoolGoal');
    $RequestSchoolGoal ->user = $this->user;
    $resultStatus = $RequestSchoolGoal->calcStatus($ID, $priority );

    return $resultStatus;
  }

  protected function isActionRequired($statuses) {
    foreach($statuses as $status) {
      if($this->user['type'] == 'a' || $this->user['type'] == 'p'){
        if($status == 'in_progress' ){
          return true;
        }
      } else {
        if($status == 'rejected' ){
          return true;
        }
      }
    }
    return false;
  }

  protected function isProjectExist($project_id, $year){
     $result = Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table) -> where('project_id=:project_id AND year=:year', array(
          ':project_id' => $project_id,
          ':year' => $year
      )) -> queryRow();

     if ($result){
       return true;
     }

     return false;
  }

  protected function doBeforeInsert($post) {
    if($this->user['type'] == ADMIN || ($this->user['type'] == PA)) {

      if($this->isProjectExist(safe($post,'project_id'),safe($post,'year'))) {
        return array(
            'code' => '409',
            'result' => false,
            'system_code' => 'ERR_DUPLICATED',
            'message' => 'This project already exists'
        );
      }

      $post['performer_id'] = Yii::app() -> db -> createCommand()
                              -> select('performer_id') -> from('spi_project')
                              -> where('id=:id ', array(':id' => safe($post,'project_id')))
                              ->queryScalar();
      return array(
          'result' => true,
          'params' => $post
      );
    } else {
      return array(
          'code' => '403',
          'result' => false,
          'system_code' => 'ERR_PERMISSION',
          'message' => 'Only Admin can create the projects'
      );

    }
  }
  
  protected function doAfterInsert($result, $params, $post) {
    if($result['code'] == '200' && safe($result, 'id')) {
      $RequestSchoolConcept = CActiveRecord::model('RequestSchoolConcept');
      $RequestSchoolConcept ->user = $this->user;
      $RequestSchoolFinance = CActiveRecord::model('RequestSchoolFinance');
      $RequestSchoolFinance ->user = $this->user;
      $RequestSchoolGoal = CActiveRecord::model('RequestSchoolGoal');
      $RequestSchoolGoal ->user = $this->user;

      $school_ids = Yii::app() -> db -> createCommand()
        -> select('prs.school_id')
        -> from('spi_project_school prs')
        -> join('spi_request req', 'req.project_id = prs.project_id')
        -> where('req.id=:id', array(':id' => $result['id']))
        -> queryColumn();

      $proj = Yii::app() -> db -> createCommand()
        -> select('rate, code')
        -> from('spi_project')
        -> where('id=:id', array(':id' => $params['project_id']))
        -> queryRow();
      $rate = $proj['rate'];

      foreach($school_ids as $school_id) {
        $data = array(
          'request_id' => $result['id'],
          'school_id'  => $school_id,
        );
        $RequestSchoolConcept->insert($data, true);
        $data['rate'] = $rate;
        if($rate <= 0.5){
          $data['overhead_cost'] = 3000 * 0.5;
        }else if($rate % 1 == 0.5) {
          $data['overhead_cost'] = 3000 * $rate;
        } else {
          $data['overhead_cost'] = 3000 * round($rate);
        };
        $data['training_cost'] = 1800;
        
        $RequestSchoolFinance->insert($data, true);
        for ($i=1; $i<=5; $i++){
          $opt = 0;
          $active = 1;
          if ($i > 3){$opt = 1;$active = 0;}
          $goalData = array(
            'request_id' => $result['id'],
            'school_id'  => $school_id,
            'goal_number'  => $i,
            'option'  => $opt,              
            'is_active'  => $active
          );
          $RequestSchoolGoal->insert($goalData, true);
          $id =  Yii::app()->db->createCommand()->select('id')->from('spi_request_school_goal')
                  ->where('request_id = :request_id AND school_id = :school_id AND goal_number = :goal_number', 
                          array(':request_id'=>$result['id'],'school_id'=>$school_id,'goal_number'=>$i))->queryScalar();
          $goals = Yii::app()->db->createCommand()->select('id')->from('spi_goal')->where('1=1')->queryAll();
          foreach ($goals as $goal){
            $RequestGoal = CActiveRecord::model('RequestGoal');
            $RequestGoal ->user = $this->user;
            $goal = array(
              'request_school_goal_id' => $id,
              'goal_id'  => $goal['id']);
            $RequestGoal->insert($goal, true);
          }
        }
      }

      
      $request = Yii::app() -> db -> createCommand()
        -> select('prf.email, req.year, req.end_fill')
        -> from('spi_request req')
        -> join('spi_performer prf', 'req.performer_id = prf.id')
        -> where('req.id=:id', array(':id' => $result['id']))
        ->queryRow();

      $emailParams = array(
          'request_code' => $proj['code'],
          'year' => $request['year'],
          'date' => date('H:i d.m.Y'),
          'request_end_date' => date('d.m.Y',strtotime($request['end_fill'])),
          'url' => Yii::app()->getBaseUrl(true).'/request/'.$result['id'],
      );

      if($request['email']) {
        Email::sendMessageByTemplate('antrag_erstellt', $emailParams, $request['email']);
      }
    }
    return $result;
  }

  public function statusUpdate($request_id){
    $row = Yii::app()->db->createCommand()->select(array('status_finance', 'status_id', 'status_id_ta'))->from($this->table)->where('id=:id', array(':id' => $request_id))->queryRow();
    $row['status_goal'] = $this->calcGoalsStatus($request_id, 'a');
    $row['status_goal_ta'] = $this->calcGoalsStatus($request_id, 't');
    $row['status_concept'] = $this->calcConceptStatus($request_id, 'a');
    $row['status_concept_ta'] = $this->calcConceptStatus($request_id, 't');
    $status_id = $this->calcStatusId($row, 'a');
    $status_id_ta = $this->calcStatusId($row, 't');

    Yii::app()->db->createCommand()->update($this->table, array(
              'status_goal' => $row['status_goal']
            , 'status_goal_ta' => $row['status_goal_ta']
            , 'status_concept' => $row['status_concept']
            , 'status_concept_ta' => $row['status_concept_ta']
            , 'status_id' => $status_id
            , 'status_id_ta' => $status_id_ta )
            , 'id=:id', array(':id' => $request_id ));
  }

  protected function doAfterUpdate($result, $params, $post, $request_id) {
    Yii::app()->db->createCommand()->update($this->table, array('last_change' => date("Y-m-d", time())), 'id=:id', array(':id' => $request_id ));
    
    $this->statusUpdate($request_id);

    if($this->school_concepts) {
      $RequestSchoolConcept = CActiveRecord::model('RequestSchoolConcept');
      $RequestSchoolConcept->user = $this->user;
      foreach ($this->school_concepts as $id=>$data) {
        $RequestSchoolConcept->update($id, $data, true);
      }
    }

    if($this->school_goals) {
      $RequestSchoolGoal = CActiveRecord::model('RequestSchoolGoal');
      $RequestSchoolGoal->user = $this->user;
      foreach ($this->school_goals as $id=>$data) {
        if(isset($data['total_count'])){
          unset($data['total_count']);
        };
        $RequestSchoolGoal->update($id, $data, true);        
      }
    }

    if($this->finance_plan) {
      $RequestSchoolFinance = CActiveRecord::model('RequestSchoolFinance');
      $RequestSchoolFinance ->user = $this->user;

      if(in_array($this->user['type'], array('a', 'p'))) {
        foreach (safe($this->finance_plan, 'schools', array()) as $data) {
          $id = $data['id'];
          unset($data['id']);

          if($data['rate']){
            if(strpos($data['rate'], '.') !== false && strpos($data['rate'], ',') !== false){
              $data['rate']  = explode('.', $data['rate']);
              $data['rate']  = $data['rate'][0].$data['rate'][1];
            }
            $data['rate']           = (float)str_replace(",", ".", $data['rate']);
          }
          if($data['training_cost']){
            if(strpos($data['training_cost'], '.') !== false && strpos($data['training_cost'], ',') !== false){
              $data['training_cost']  = explode('.', $data['training_cost']);
              $data['training_cost']  = $data['training_cost'][0].$data['training_cost'][1];
            }
            $data['training_cost']  = (float)str_replace(",", ".", $data['training_cost']);
          }
          if($data['overhead_cost']){
            if(strpos($data['overhead_cost'], '.') !== false && strpos($data['overhead_cost'], ',') !== false){
              $data['overhead_cost']  = explode('.', $data['overhead_cost']);
              $data['overhead_cost']  = $data['overhead_cost'][0].$data['overhead_cost'][1];
            }
            $data['overhead_cost']  = (float)str_replace(",", ".", $data['overhead_cost']);
          }
          $res = $RequestSchoolFinance->update($id, $data, true);
        }
      }

      if(safe($this->finance_plan, 'prof_associations', array())) {
        $RequestProfAssociation = CActiveRecord::model('RequestProfAssociation');
        $RequestProfAssociation ->user = $this->user;

        foreach ($this->finance_plan['prof_associations'] as $data) {
          if($id = safe($data,'id')) {
            if($data['sum']){
              if(strpos($data['sum'], '.') !== false && strpos($data['sum'], ',') !== false){
                $data['sum']  = explode('.', $data['sum']);
                $data['sum']  = $data['sum'][0].$data['sum'][1];
              }
              $data['sum']  = (float)str_replace(",", ".", $data['sum']);
            }
            unset($data['id']);
            if(safe($data,'is_deleted')) {
              $RequestProfAssociation->delete($id, true);
            } else {
              $RequestProfAssociation->update($id, $data, true);
            }
          } elseif(!safe($data,'is_deleted')) {
            if($data['sum']){
              if(strpos($data['sum'], '.') !== false && strpos($data['sum'], ',') !== false){
                $data['sum']  = explode('.', $data['sum']);
                $data['sum']  = $data['sum'][0].$data['sum'][1];
              }
              $data['sum']  = (float)str_replace(",", ".", $data['sum']);
            }
            $data['request_id'] = $request_id;
            $res = $RequestProfAssociation->insert($data, true);
          }
        }
      }

      if(safe($this->finance_plan,'users', array())) {
        $RequestUser = CActiveRecord::model('RequestUser');
        $RequestUser ->user = $this->user;
        foreach ($this->finance_plan['users'] as $data) {
          if($data['cost_per_month_brutto']){
            if(strpos($data['cost_per_month_brutto'], '.') !== false && strpos($data['cost_per_month_brutto'], ',') !== false){
              $data['cost_per_month_brutto']  = explode('.', $data['cost_per_month_brutto']);
              $data['cost_per_month_brutto']  = $data['cost_per_month_brutto'][0].$data['cost_per_month_brutto'][1];
            }
            $data['cost_per_month_brutto']  = (float)str_replace(",", ".", $data['cost_per_month_brutto']);
          }
          if($data['hours_per_week']){
            if(strpos($data['hours_per_week'], '.') !== false && strpos($data['hours_per_week'], ',') !== false){
              $data['hours_per_week']  = explode('.', $data['hours_per_week']);
              $data['hours_per_week']  = $data['hours_per_week'][0].$data['hours_per_week'][1];
            }
            $data['hours_per_week']  = (float)str_replace(",", ".", $data['hours_per_week']);
          }
          if($data['have_annual_bonus'] == 1 && $data['annual_bonus']){
            if(strpos($data['annual_bonus'], '.') !== false && strpos($data['annual_bonus'], ',') !== false){
              $data['annual_bonus']  = explode('.', $data['annual_bonus']);
              $data['annual_bonus']  = $data['annual_bonus'][0].$data['annual_bonus'][1];
            }
            $data['annual_bonus']  = (float)str_replace(",", ".", $data['annual_bonus']);
          }
          if($data['have_additional_provision_vwl'] == 1 && $data['additional_provision_vwl']){
            if(strpos($data['additional_provision_vwl'], '.') !== false && strpos($data['additional_provision_vwl'], ',') !== false){
              $data['additional_provision_vwl']  = explode('.', $data['additional_provision_vwl']);
              $data['additional_provision_vwl']  = $data['additional_provision_vwl'][0].$data['additional_provision_vwl'][1];
            }
            $data['additional_provision_vwl']  = (float)str_replace(",", ".", $data['additional_provision_vwl']);
          }
          if($data['have_supplementary_pension'] == 1 && $data['supplementary_pension']){
            if(strpos($data['supplementary_pension'], '.') !== false && strpos($data['supplementary_pension'], ',') !== false){
              $data['supplementary_pension']  = explode('.', $data['supplementary_pension']);
              $data['supplementary_pension']  = $data['supplementary_pension'][0].$data['supplementary_pension'][1];
            }
            $data['supplementary_pension']  = (float)str_replace(",", ".", $data['supplementary_pension']);
          }
          unset($data['new_user_name']);
          if($id = safe($data,'id')) {
            unset($data['id']);
            if(safe($data,'is_deleted')) {
              $RequestUser->delete($id, true);
            } else {
              $RequestUser->update($id, $data, true);
            }
          } else {
            $result = true;
            $req_users = $RequestUser->select(array('request_id'=>$request_id), true);
            $users = $req_users['result'];
            foreach ($users as $user){
              if(safe($data,'user_id') && $user['user_id'] == $data['user_id']){
                $result = false;
              };
            };
            $data['request_id'] = $request_id;
            if($result){
              $RequestUser->insert($data, true);
            }
          }
        }
      }
    }
    
    $request = Yii::app() -> db -> createCommand()
        -> select('(SELECT code FROM spi_project WHERE id = rq.project_id) code, (SELECT email FROM spi_user WHERE id = rq.finance_user_id) finance_user_email, rq.end_fill')
        -> from('spi_request rq')
        -> where('rq.id=:id', array(':id' => $request_id))
        ->queryRow();
    if(safe($post, 'status_finance') == 'rejected' && $post['old']['status_finance'] != 'rejected') {
      $emailParams = array(
          'request_code' => $request['code'],
          'request_end_date' => date('d.m.Y',strtotime($request['end_fill'])),
          'part' => 'finanzplan',
          'comment' => safe($post, 'finance_comment'),
          'date' => date('H:i d.m.Y'),
          'url' => Yii::app()->getBaseUrl(true).'/request/'.$request_id.'#finance-plan',
      );

      if($request['finance_user_email']) {
        Email::sendMessageByTemplate('antrag_reject', $emailParams, $request['finance_user_email']);
      }
    }

    $Request = CActiveRecord::model('RequestLock');
    $Request->user = $this->user;
    $isExistRequestLock = $this->isExistRequestLock($request_id);

    if ((safe($post, 'status_id') == 4  || safe($post, 'status_id') == 5) ){
      if($post['old']['status_id'] != 4 && $post['old']['status_id'] != 5){
        $Request->delete($isExistRequestLock, true);
        $Request->insert(array('request_id'=>$request_id, ), true);
      }
    } else {
      if($isExistRequestLock){
        $Request->delete($isExistRequestLock, true);
      }
    }

    if((safe($post, 'status_id') == 4 && $post['old']['status_id'] != 4) || (safe($post, 'status_id') == 5 && $post['old']['status_id'] != 5)) {
      $emailParams = array(
          'request_code' => $request['code'],
          'date' => date('H:i d.m.Y'),
          'url' => Yii::app()->getBaseUrl(true).'/request/'.$request_id,
      );

      $template = safe($post, 'status_id') == 4?'antrag_acknowledge':'antrag_approved';
      if($request['finance_user_email']) {
        Email::sendMessageByTemplate($template, $emailParams, $request['finance_user_email']);
      }
    }
    if(safe($post, 'end_fill') != safe($post['old'],'end_fill')) {
      $emailParams = array(
          'request_code' => $request['code'],
          'request_end_date' => date('d.m.Y',strtotime($request['end_fill'])),
          'request_end_date_old' => date('d.m.Y',strtotime($post['old']['end_fill'])),
          'date' => date('H:i d.m.Y'),
          'url' => Yii::app()->getBaseUrl(true).'/request/'.$request_id,
      );

      if($request['finance_user_email']) {
        Email::sendMessageByTemplate('request_end_date_is_changed', $emailParams, $request['finance_user_email']);
      }
    }
    
    return $result;
  }

  protected function isExistRequestLock($request_id){
    $result = false;

    $Request = CActiveRecord::model('RequestLock');
    $Request->user = $this->user;

    $result = Yii::app() -> db -> createCommand()
                              -> select('id')
                              -> from('spi_request_lock')
                              -> where('request_id=:request_id', array(':request_id'=>$request_id))
                              -> queryScalar();
    return $result;
  }


  protected function doAfterSelect($result) {

    if (isset($_GET['id'])){
      $row = $result['result'][0];

      $row['schools'] = Yii::app() -> db -> createCommand()
                                      -> select("sch.*
                                                ,CONCAT(IF(user.sex = 1, 'Herr', 'Frau' ), ' ' , user.first_name, ' ', user.last_name)  user_name
                                                , user.function user_function")
                                      -> from('spi_project_school prj_sch')
                                      -> join( 'spi_school sch', 'prj_sch.school_id = sch.id' )
                                      -> leftJoin( 'spi_user user', 'user.id = sch.contact_id' )
                                      -> where('prj_sch.project_id=:id', array(':id' => $row['project_id']))
                                      -> queryAll();
      foreach ($row['schools'] as $key=>$schoolData) {
        $row['schools'][$schoolData['id']] = $schoolData;
        unset ($row['schools'][$key]);
      }

      if($row['status_id'] == '4' || $row['status_id'] == '5'){
        $row = $this->changeToLock($row);
      }

      $result['result'] =  $row;

    }else {
      foreach($result['result'] as &$row) {
        if($row['project_id']){
          $schools = Yii::app() -> db -> createCommand()
          -> select('scl.*, sct.name type_name') -> from('spi_project_school prs')
          -> leftJoin('spi_school scl', 'prs.school_id=scl.id')
          -> join('spi_school_type sct', 'sct.id=scl.type_id')
          -> where('prs.project_id=:id', array(':id' => $row['project_id']))
          -> queryAll();
          $ordered_schools = $schools;
          foreach ($ordered_schools as $key=>$schoolData) {
            $ordered_schools[$schoolData['name']] = $ordered_schools[$key];
            unset ($ordered_schools[$key]);
          }
          ksort($ordered_schools);
          $row['ordered_schools'] = $ordered_schools;
          $row['schools'] = $schools;
        }

        if(isset($row['schools']))  {
          foreach ($row['schools'] as $key=>$schoolData) {
            $row['schools'][$schoolData['id']] = $schoolData;
            unset ($row['schools'][$key]);
            if($schoolData['contact_id']){
              $contact = Yii::app() -> db -> createCommand()
              -> select('usr.*') -> from('spi_user usr')
              -> where('usr.id=:contact_id', array(':contact_id' => $schoolData['contact_id'])) 
              -> queryAll();
              if(safe($contact,0)){                
                if($contact[0]['sex'] == '1'){
                  $contact[0]['sex'] = 'Herr';
                }else if($contact[0]['sex'] == '2'){
                  $contact[0]['sex'] = 'Frau';
                }else{
                  $contact[0]['sex'] = '-';
                }
                $row['schools'][$schoolData['id']]['contact_sex'] = $contact[0]['sex'];
                $row['schools'][$schoolData['id']]['contact_title'] = $contact[0]['title'];
                $row['schools'][$schoolData['id']]['contact_first_name'] = $contact[0]['first_name'];
                $row['schools'][$schoolData['id']]['contact_last_name'] = $contact[0]['last_name'];
              }
            }            
          }
        }

        $old = $row;
        if($row['status_id'] == '4' || $row['status_id'] == '5'){
          $row = $this->changeToLock($row);
        }
        $new = $row;
        
        if($row['performer_id']){
          $performer = Yii::app() -> db -> createCommand()
          -> select('prf.*') -> from('spi_performer prf')
          -> where('prf.id=:performer_id', array(':performer_id' => $row['performer_id'])) 
          -> queryAll();
          if(safe($performer,0)){
            $row['performer'] = $performer[0];
          }
        }
        
        if($row['performer'] && $row['performer']['representative_user_id'] ){
          $representative = Yii::app() -> db -> createCommand()
          -> select('usr.*') -> from('spi_user usr')
          -> where('usr.id=:representative_user_id', array(':representative_user_id' => $row['performer']['representative_user_id'])) 
          -> queryAll();
          if(safe($representative,0)){
            if($representative[0]['sex'] == '1'){
              $representative[0]['sex'] = 'Herr';
            }else if($representative[0]['sex'] == '2'){
              $representative[0]['sex'] = 'Frau';
            }else{
              $representative[0]['sex'] = '-';
            }
            $row['representative'] = $representative[0];
          }          
        }
        
        if($row['concept_user_id']){
          $concept_user = Yii::app() -> db -> createCommand()
          -> select('usr.*') -> from('spi_user usr')
          -> where('usr.id=:concept_user_id', array(':concept_user_id' => $row['concept_user_id'])) 
          -> queryAll();
          if(safe($concept_user,0)){
            if($concept_user[0]['sex'] == '1'){
              $concept_user[0]['sex'] = 'Herr';
            }else if($concept_user[0]['sex'] == '2'){
              $concept_user[0]['sex'] = 'Frau';
            }else{
              $concept_user[0]['sex'] = '-';
            }
            $row['concept_user'] = $concept_user[0];
          }          
        }
        
        if($row['finance_user_id']){
          $finance_user = Yii::app() -> db -> createCommand()
          -> select('usr.*') -> from('spi_user usr')
          -> where('usr.id=:finance_user_id', array(':finance_user_id' => $row['finance_user_id'])) 
          -> queryAll();
          if(safe($finance_user,0)){
            if($finance_user[0]['sex'] == '1'){
              $finance_user[0]['sex'] = 'Herr';
            }else if($finance_user[0]['sex'] == '2'){
              $finance_user[0]['sex'] = 'Frau';
            }else{
              $finance_user[0]['sex'] = '-';
            }
            $row['finance_user'] = $finance_user[0];
          }          
        }
        
        if($row['bank_details_id']){
          $bank_details = Yii::app() -> db -> createCommand()
          -> select('bnk.*') -> from('spi_bank_details bnk')
          -> where('bnk.id=:bank_details_id', array(':bank_details_id' => $row['bank_details_id'])) 
          -> queryAll();
          if(safe($bank_details,0)){
            $row['bank_details'] = $bank_details[0];
          }          
        }
        
        if($row['district_id']){
          $district = Yii::app() -> db -> createCommand()
          -> select('dst.*') -> from('spi_district dst')
          -> where('dst.id=:district_id', array(':district_id' => $row['district_id'])) 
          -> queryAll();
          if(safe($district,0)){
            $row['district'] = $district[0];
          }
        }
        
        if($row['district'] && $row['district']['contact_id'] ){
          $contact_user = Yii::app() -> db -> createCommand()
          -> select('usr.*') -> from('spi_user usr')
          -> where('usr.id=:contact_id', array(':contact_id' => $row['district']['contact_id'])) 
          -> queryAll();
          if(safe($contact_user,0)){
            $last_name = '';
            if(safe($contact_user[0], 'last_name')){
              $last_name = $contact_user[0]['last_name'];
            };
            $first_name = '';
            if(safe($contact_user[0], 'first_name')){
              $first_name = $contact_user[0]['first_name'];
            };
            $row['district_contact_name'] = $last_name . ' ' . $first_name;
          };
        }
      }

    }

    return $result;
  }

  protected function changeToLock($row){
    $id = $row['id'];
    $lock_result = Yii::app() -> db -> createCommand()
                                      -> select("*")
                                      -> from('spi_request_lock tbl')
                                      -> where('tbl.request_id=:id', array(':id' => $id))
                                      -> queryRow();

    unset($lock_result['id']);

    


    if(!$lock_result){
      return $row;
    } else {
      $new_row = array_replace ($row, $lock_result);

      if($new_row['start_date']   == '0000-00-00'){ $new_row['start_date']  = ''; }
      if($new_row['due_date']     == '0000-00-00'){ $new_row['due_date']    = ''; }
      if($new_row['last_change']  == '0000-00-00'){ $new_row['last_change'] = ''; }
      if($new_row['end_fill']     == '0000-00-00'){ $new_row['end_fill']    = ''; }


      if(array_key_exists ( 'schools' , $new_row)){
        foreach ($new_row['schools'] as &$school){
          $school_lock_result = Yii::app() -> db -> createCommand()
                                          -> select("*")
                                          -> from('spi_school_lock tbl')
                                          -> where('tbl.request_id=:id', array(':id' => $id))
                                          -> andWhere('tbl.school_id=:s_id', array(':s_id' => $school['id']))
                                          -> queryRow();
        unset($school_lock_result['id']);
        
      if(is_array($school_lock_result)){
        $school = array_replace ($school , $school_lock_result);
      }
        }
        
      }
    }

    


    if($new_row){
      return $new_row;
    } else {
      return $row;
    }
  }

  protected function doBeforeUpdate($post, $id) {

    unset($post['status_code']);

    if(isset($post['doc_target_agreement_id']) && !$post['doc_target_agreement_id']) {
      $post['doc_target_agreement_id'] = null;
    }
    if(isset($post['doc_financing_agreement_id']) && !$post['doc_financing_agreement_id']) {
      $post['doc_financing_agreement_id'] = null;
    }
    if(isset($post['doc_request_id']) && !$post['doc_request_id']) {
      $post['doc_request_id'] = null;
    }

    if(isset($post['school_concepts'])) {
      $this->school_concepts = $post['school_concepts'];
      unset($post['school_concepts']);
    }

    if(isset($post['school_goals'])) {
      $this->school_goals = $post['school_goals'];
      unset($post['school_goals']);
    }

    if(isset($post['finance_plan'])) {
      $this->finance_plan = $post['finance_plan'];
      unset($post['finance_plan']);
    }

    if(isset($post['revenue_sum'])) {
      if(strpos($post['revenue_sum'], '.') !== false && strpos($post['revenue_sum'], ',') !== false){
        $post['revenue_sum']  = explode('.', $post['revenue_sum']);
        $post['revenue_sum']  = $post['revenue_sum'][0].$post['revenue_sum'][1];
      }
      $post['revenue_sum'] = (float)str_replace(",", ".", $post['revenue_sum']);
    }
    if(isset($post['emoloyees_cost'])) {
      $post['emoloyees_cost'] = (float)str_replace(",", ".", $post['emoloyees_cost']);
    }
    if(isset($post['training_cost'])) {
      $post['training_cost'] = (float)str_replace(",", ".", $post['training_cost']);
    }
    if(isset($post['overhead_cost'])) {
      $post['overhead_cost'] = (float)str_replace(",", ".", $post['overhead_cost']);
    }
    if(isset($post['prof_association_cost'])) {
      $post['prof_association_cost'] = (float)str_replace(",", ".", $post['prof_association_cost']);
    }
    if(isset($post['total_cost'])) {
      $post['total_cost'] = (float)str_replace(",", ".", $post['total_cost']);
    }
    
    $prams = $post;
    $post['old'] = Yii::app() -> db -> createCommand()
        -> select('rq.*')
        -> from($this -> table . ' rq')
        -> where('rq.id=:id', array(':id' => $id))
        ->queryRow();

    
    return array (
      'result' => true,
      'params' => $prams,
      'post' => $post
    );

  }

  protected function doBeforeDelete($id) {
    $exists = Yii::app() -> db -> createCommand() -> select('tbl.id') -> from($this -> table . ' tbl') -> where('id=:id', array(
      ':id' => $id
    )) -> queryScalar();
    if (!$exists) {
      return array(
        'code' => '409',
        'result' => false,
        'system_code' => 'ERR_NOT_EXISTS'
      );
    }

    $RequestSchoolConcept = CActiveRecord::model('RequestSchoolConcept');
    $RequestSchoolConcept->user = $this->user;
    if($concepts = Yii::app() -> db -> createCommand() -> select('tbl.id') -> from('spi_request_school_concept tbl') -> where('request_id=:id', array(
      ':id' => $id
    )) -> queryAll()) {
      foreach($concepts as $concept) {
        $RequestSchoolConcept->delete($concept['id'], true);
      }
    }

    $RequestSchoolGoal = CActiveRecord::model('RequestSchoolGoal');
    $RequestSchoolGoal->user = $this->user;
    if($goals = Yii::app() -> db -> createCommand() -> select('tbl.id') -> from('spi_request_school_goal tbl') -> where('request_id=:id', array(
      ':id' => $id
    )) -> queryAll()) {
      foreach($goals as $goal) {
        $RequestSchoolGoal->delete($goal['id'], true);
      }
    }

    return array(
      'result' => true
    );
  }

  public function copy($post){
    if(safe($post, 'ids')) {
//      $RequestSchoolConcept = CActiveRecord::model('RequestSchoolConcept');
//      $RequestSchoolConcept ->user = $this->user;
//      $RequestSchoolGoal = CActiveRecord::model('RequestSchoolGoal');
//      $RequestSchoolGoal ->user = $this->user;
      $RequestSchoolFinance = CActiveRecord::model('RequestSchoolFinance');
      $RequestSchoolFinance ->user = $this->user;
      $RequestUser = CActiveRecord::model('RequestUser');
      $RequestUser ->user = $this->user;
      $RequestProfAssociation = CActiveRecord::model('RequestProfAssociation');
      $RequestProfAssociation ->user = $this->user;


      $ids = !is_array($post['ids']) ? array($post['ids']) : $post['ids'];
      $year = safe($post, 'year');
      $this->copy = true;
      unset($post['ids']);
      unset($post['year']);
      unset($post['copy']);
      $value = array();
      foreach($ids as $oldId) {
        $res = $this->select(array('id'=>$oldId), true);
        $command = Yii::app() -> db -> createCommand() -> select(' tbl.project_id') -> from($this -> table . ' tbl');
        $command -> where('id = :id', array(':id' => $oldId));
        $value = $command ->queryRow();

        if($value){
          $value['year'] = $year;

          $newId = false;
          $insertResult = $this->insert($value, true);
          if($insertResult['result']){
            $newId = $insertResult['id'];
          }


          $this->updateData('spi_request_school_finance', $RequestSchoolFinance, $oldId, $newId );
//          $this->copyData('spi_request_user', $RequestUser, $oldId, $newId );
//          $this->copyData('spi_request_prof_association', $RequestProfAssociation, $oldId, $newId );
        }



      }
      response(200, array ('result' => true, 'system_code' => 'SUCCESSFUL'), 'post');
    }
  }
  public function massCreate ($post){
     if(safe($post, 'project_ids')) {

      $project_ids = !is_array($post['project_ids']) ? array($post['project_ids']) : $post['project_ids'];
      $year = safe($post, 'year');

      unset($post['project_ids']);
      unset($post['year']);
      unset($post['massCreate']);

       foreach($project_ids as $project_id) {
         $value['year'] = $year;
         $value['project_id'] = $project_id;
         $insertResult = $this->insert($value, true);
       }
     }
     response(200, array ('result' => true, 'system_code' => 'SUCCESSFUL'), 'post');
  }
  public function copyDataConceptGoal ($post){
     $newId = safe($post, 'request_id');
     $year = safe($post, 'year');
     $project_code = safe($post, 'project_code');

    if($newId) {

        $command = Yii::app() -> db -> createCommand() -> select('tbl.id') -> from($this -> table . ' tbl');
        $command ->leftJoin('spi_project prj', 'tbl.project_id = prj.id');
        $command -> where('prj.code = :project_code', array(':project_code' => $project_code));
        $command -> andWhere('year = :year', array(':year' => $year));
        $oldId = $command ->queryScalar();

      $RequestSchoolConcept = CActiveRecord::model('RequestSchoolConcept');
      $RequestSchoolConcept ->user = $this->user;
      $RequestSchoolGoal = CActiveRecord::model('RequestSchoolGoal');
      $RequestSchoolGoal ->user = $this->user;

      if($newId && $oldId){

        $this->updateData('spi_request_school_concept',$RequestSchoolConcept, $oldId, $newId );
        $this->updateData('spi_request_school_goal', $RequestSchoolGoal, $oldId, $newId );
        response(200, array ('result' => true, 'system_code' => 'SUCCESSFUL'), 'post');
      } else {
        response(409, array ('result' => false, 'system_code' => 'ERR_INVALID_QUERY'), 'post');
      }

    } else {
      response(409, array ('result' => false, 'system_code' => 'ERR_ID_NOT_SPECIFIED'), 'post');
    }
    
   }

  protected function copyData($table, $model, $oldId, $newId){

    $command = Yii::app() -> db -> createCommand() -> select('*') -> from($table);
    $command -> where('request_id = :id', array(':id' => $oldId));
    $value = $command ->queryAll();

    foreach ($value as $row) {
      switch ($table) {
        case 'spi_request_school_finance':
          if($row['rate'] <= 0.5){
            $row['overhead_cost'] = 3000 * 0.5;
          }else if($row['rate'] % 1 == 0.5) {
            $row['overhead_cost'] = 3000 * $row['rate'];
          } else {
            $row['overhead_cost'] = 3000 * round($row['rate']);
          };
          $row['training_cost'] = 1800;
          break;
        case 'spi_request_school_concept':
        case 'spi_request_school_goal':
           $row['status'] = 'unfinished';
          break;
        default:

          break;
      }   
      $id = $row['id'];
      unset($row['id']);

      $row['request_id'] = $newId;
      $model->insert($row, true);
      
      if($table == 'spi_request_school_goal'){
        $RequestGoal = CActiveRecord::model('RequestGoal');
        $RequestGoal ->user = $this->user;
        $goal_command = Yii::app() -> db -> createCommand() -> select('*') -> from('spi_request_goal');
        $goal_command -> where('request_school_goal_id = :id', array(':id' => $id));
        $new_value_goal = $goal_command ->queryAll();
        $last_id = Yii::app()->db->createCommand()->select('id')->from('spi_request_school_goal')
                  ->where('request_id = :request_id AND school_id = :school_id AND goal_number = :goal_number', 
                          array(':request_id'=>$row['request_id'],'school_id'=>$row['school_id'],'goal_number'=>$row['goal_number']))->queryScalar();     
        foreach ($new_value_goal as $row_goal) {
          $row_goal['request_school_goal_id'] = $last_id;
          unset($row_goal['id']);
          $RequestGoal->insert($row_goal, true);
        };
      };
      
    }

  }

  protected function updateData($table, $model,$oldId, $newId){

    $command = Yii::app() -> db -> createCommand() -> select('*') -> from($table);
    $command -> where('request_id = :id', array(':id' => $newId));
    $new_value = $command ->queryAll();

    foreach ($new_value as $row) {
      if($table == 'spi_request_school_goal'){
        $RequestGoal = CActiveRecord::model('RequestGoal');
        $RequestGoal ->user = $this->user;
        $goal_command = Yii::app() -> db -> createCommand() -> select('*') -> from('spi_request_goal');
        $goal_command -> where('request_school_goal_id = :id', array(':id' => $row['id']));
        $new_value_goal = $goal_command ->queryAll();
        
        foreach ($new_value_goal as $row_goal) {
          $RequestGoal->delete($row_goal['id'],  true);
        }
      }
      $model->delete($row['id'],  true);
    }

    $this->copyData($table, $model, $oldId, $newId);
  }

}
