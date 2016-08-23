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
                      , IF(prj.type_id = 3, 1, 0) is_bonus_project
                      , prj.id project_id
                      , fns.programm
                      ,(SELECT name FROM spi_school scl WHERE scl.id=prj.id) AS `school_name`";

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
      $command -> join( 'spi_finance_source fns', 'prj.programm_id         = fns.id' );
      $command -> where(' 1=1 ', array());

    }
    return $command;
  }

  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'YEAR')) {
      $command -> andWhere('tbl.year = :year', array(':year' => $params['YEAR']));
    }
    if(safe($params, 'PERFORMER_ID')) {
      $command -> andWhere('prf.id = :performer_id', array(':performer_id' => $params['PERFORMER_ID']));
    }
    if(safe($params, 'PROJECT_TYPE_ID')) {
      $command -> andWhere('prj.type_id = :type_id', array(':type_id' => $params['PROJECT_TYPE_ID']));
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
    if(safe($params, 'NO_RATE')) {
      $command -> leftJoin('spi_financial_request frq', 'frq.request_id = tbl.id');
      $command -> andWhere('frq.no_rate = :no_rate', array(':no_rate' => $params['NO_RATE']));
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
        $string .= "tbl.".$page." = '".$status."' OR ";
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
    if(!$this->copy && $result['code'] == '200' && safe($result, 'id')) {
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

      $rate = Yii::app() -> db -> createCommand()
        -> select('rate')
        -> from('spi_project')
        -> where('id=:id', array(':id' => $params['project_id']))
        -> queryScalar();

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
            'goal_id'  => $i,
            'option'  => $opt,              
            'is_active'  => $active,
            'name' => 'Entwicklungsziel ' . $i
          );
          $RequestSchoolGoal->insert($goalData, true);
        }
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
            $data['rate']           = (float)str_replace(",", ".", $data['rate']);
          }
          if($data['training_cost']){
            $data['training_cost']  = (float)str_replace(",", ".", $data['training_cost']);
          }
          if($data['overhead_cost']){
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
          unset($data['new_user_name']);
          if($id = safe($data,'id')) {
            unset($data['id']);
            if(safe($data,'is_deleted')) {
              $RequestUser->delete($id, true);
            } else {
              $RequestUser->update($id, $data, true);
            }
          } else {
            $data['request_id'] = $request_id;
            $RequestUser->insert($data, true);
          }
        }
      }
    }
    
    if(safe($post, 'status_finance') == 'rejected') {
      $request = Yii::app() -> db -> createCommand()
        -> select('rq.id request_id, (SELECT code FROM spi_project WHERE id = rq.project_id) code, (SELECT email FROM spi_user WHERE id = rq.finance_user_id) finance_user_email')
        -> from('spi_request rq')
        -> where('rq.id=:id', array(':id' => $request_id))
        ->queryRow();

      $emailParams = array(
          'request_code' => $request['code'],
          'part' => 'finanzplan',
          'comment' => safe($post, 'finance_comment'),
          'date' => date('H:i d.m.Y'),
          'url' => Yii::app()->getBaseUrl(true).'/request/'.safe($request, 'request_id').'#finance-plan',
      );

      if($request['finance_user_email']) {
        Email::sendMessageByTemplate('antrag_reject', $emailParams, $request['finance_user_email']);
      }
    }

     if (safe($post, 'status_id') == 5 ){

      $Request = CActiveRecord::model('RequestLock');
      $Request->user = $this->user;
      $Request->insert(array('request_id'=>$request_id));

    }

    if(safe($post, 'status_id') == 4 || safe($post, 'status_id') == 5 ) {
      $request = Yii::app() -> db -> createCommand()
        -> select('(SELECT code FROM spi_project WHERE id = rq.project_id) code, (SELECT email FROM spi_user WHERE id = rq.finance_user_id) finance_user_email')
        -> from('spi_request rq')
        -> where('rq.id=:id', array(':id' => $request_id))
        ->queryRow();

      $emailParams = array(
          'request_code' => $request['code'],
          'date' => date('H:i d.m.Y'),
          'url' => Yii::app()->getBaseUrl(true).'/request/'.safe($post, 'request_id').'#finance-plan',
      );

      $template = safe($post, 'status_id') == 4?'antrag_acknowledge':'antrag_acknowledge';
      if($request['finance_user_email']) {
        Email::sendMessageByTemplate($template, $emailParams, $request['finance_user_email']);
      }
    }
    
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

      if($row['status_id'] == '5'){
        $row = $this->changeToLock($row);
      }

      $result['result'] =  $row;

    }else {
      foreach($result['result'] as &$row) {
        if($row['project_id']){
          $schools = Yii::app() -> db -> createCommand()
          -> select('scl.*') -> from('spi_project_school prs')
          -> leftJoin('spi_school scl', 'prs.school_id=scl.id')
          -> where('prs.project_id=:id', array(':id' => $row['project_id'])) 
          -> queryAll();
          $row['schools'] = $schools;
        }

        $old = $row;
        if($row['status_id'] == '5'){
          $row = $this->changeToLock($row);
        }
        $new = $row;

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
    if(isset($post['prof_association_cost'])) {
      $post['prof_association_cost'] = (float)str_replace(",", ".", $post['prof_association_cost']);
    }
    if(isset($post['total_cost'])) {
      $post['total_cost'] = (float)str_replace(",", ".", $post['total_cost']);
    }


    return array (
      'result' => true,
      'params' => $post,
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
      $RequestSchoolConcept = CActiveRecord::model('RequestSchoolConcept');
      $RequestSchoolConcept ->user = $this->user;
      $RequestSchoolFinance = CActiveRecord::model('RequestSchoolFinance');
      $RequestSchoolFinance ->user = $this->user;
      $RequestSchoolGoal = CActiveRecord::model('RequestSchoolGoal');
      $RequestSchoolGoal ->user = $this->user;

      $ids = !is_array($post['ids']) ? array($post['ids']) : $post['ids'];
      $year = safe($post, 'year');
      $this->copy = true;
      unset($post['ids']);
      unset($post['year']);
      unset($post['copy']);
      foreach($ids as $oldId) {
        $res = $this->select(array('id'=>$oldId), true);
        $command = Yii::app() -> db -> createCommand() -> select('*') -> from($this -> table . ' tbl');
        $command -> where('id = :id', array(':id' => $oldId));
        $value = $command ->queryRow();

        if($value){
          $value['year'] = $year;

          $value['status_finance']    = ($value['status_finance']    == 'unfinished') ? $value['status_finance']    : 'in_progress';
          $value['status_concept']    = ($value['status_concept']    == 'unfinished') ? $value['status_concept']    : 'in_progress';
          $value['status_concept_ta'] = ($value['status_concept_ta'] == 'unfinished') ? $value['status_concept_ta'] : 'in_progress';
          $value['status_goal']       = ($value['status_goal']       == 'unfinished') ? $value['status_goal']       : 'in_progress';
          $value['status_goal_ta']    = ($value['status_goal_ta']    == 'unfinished') ? $value['status_goal_ta']    : 'in_progress';

          $value['status_id'] = $this->calcStatusId($value, 'a');
          $value['status_id_ta'] = $this->calcStatusId($value, 't');

          unset ($value['id']);
          unset ($value['start_date']);
          unset ($value['due_date']);
          unset ($value['end_fill']);
          unset ($value['last_change']);
          $newId = false;
          $insertResult = $this->insert($value, true);
          if($insertResult['result']){
            $newId = $insertResult['id'];
          }

          $this->copyData('spi_request_school_concept',$RequestSchoolConcept, $oldId, $newId );
          $this->copyData('spi_request_school_goal', $RequestSchoolGoal, $oldId, $newId );
          $this->copyData('spi_request_school_finance', $RequestSchoolFinance, $oldId, $newId );
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

  protected function copyData($table, $model,$oldId, $newId){
    $command = Yii::app() -> db -> createCommand() -> select('*') -> from($table);
    $command -> where('request_id = :id', array(':id' => $oldId));
    $value = $command ->queryAll();

    foreach ($value as $row) {
      unset($row['id']);
      if($table != 'spi_request_school_finance' && $row['status'] != 'unfinished'){
        $row['status'] = 'in_progress';
      }
      $row['request_id'] = $newId;
      $model->insert($row, true);
    }
  }
}
