<?php
require_once ('utils/utils.php');


class Request extends BaseModel {
  public $table = 'spi_request';
  public $post = array();
  public $school_concepts = array();
  public $select_all = "tbl.*
                      , prf.name performer_name
                      , rqs.name status_name
                      , rqs.code status_code
                      , prj.code code
                      , fns.programm";
  protected function getCommand() {
    if(safe($_GET, 'list') == 'year') {
      $command = Yii::app() -> db -> createCommand()->select('year')->from($this -> table)->group('year');
    } elseif (isset($_GET['id'])){
      $this -> select_all = "tbl.*
                            , prj.id project_id
                            , prj.code code

                            , prf.id performer_id
                            , prf.name performer_name
                            , prf.address performer_address
                            , prf.plz performer_plz
                            , prf.city performer_city
                            , prf.homepage performer_homepage
                            , prf.phone performer_phone
                            , prf.fax performer_fax
                            , prf.email performer_email
                            , prf_user.function performer_contact_function
                            , CONCAT(prf_user.title, ' ' , prf_user.first_name, ' ', prf_user.last_name) performer_contact

                            , dst.id district_id
                            , dst.name district_name
                            , dst.address district_address
                            , dst.plz district_plz
                            , dst.city district_city
                            , dst.phone district_phone
                            , dst.fax district_fax
                            , dst.email district_email
                            , dst.homepage district_homepage
                            , CONCAT(user.title, ' ' , user.first_name, ' ', user.last_name) district_contact

                            ";
      $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
      $command -> join( 'spi_request_status rqs',     'tbl.status_id           = rqs.id' );
      $command -> join( 'spi_performer prf',          'tbl.performer_id        = prf.id' );
      $command -> leftJoin( 'spi_user prf_user',          'prf_user.id             = prf.representative_user_id' );
      $command -> join( 'spi_project prj',            'tbl.project_id          = prj.id' );
      $command -> join( 'spi_district dst',           'dst.id                  = prj.district_id' );
      $command -> join( 'spi_user user',              'user.id                 = dst.contact_id' );
      $command -> where(' 1=1 ', array());

    } else {
      $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
      $command -> join( 'spi_request_status rqs', 'tbl.status_id           = rqs.id' );
      $command -> leftJoin( 'spi_performer prf',      'tbl.performer_id        = prf.id' );
      $command -> join( 'spi_project prj',        'tbl.project_id          = prj.id' );
      $command -> join( 'spi_finance_source fns', 'prj.type_id = fns.project_type_id' );
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
//    if(safe($params, 'FINANCE_TYPE')) {
//      $command -> andWhere('prj.finance_source_type = :finance_type', array(':finance_type' => $params['FINANCE_TYPE']));
//    }
    if(safe($params, 'PROGRAM_ID')) {
      $command -> andWhere('fns.id = :program_id', array(':program_id' => $params['PROGRAM_ID']));
    }
    if(safe($params, 'STATUS_ID')) {
      $command -> andWhere('rqs.id = :status_id', array(':status_id' => $params['STATUS_ID']));
    }
//        print_r ($command->text);
    return $command;
  }

  protected function calcResults($result) {
    if(safe($_GET, 'list') == 'year') {
      foreach($result['result'] as &$row) {
        $row = (int)$row['year'];
      }
      if(!in_array(date("Y"), $result['result'])) {
        array_push($result['result'], (int)date("Y"));
      }
    } else {
      foreach($result['result'] as &$row) {
        $row['start_date_unix'] = strtotime($row['start_date']).'000';
        $row['due_date_unix'] = strtotime($row['due_date']).'000';
        $row['last_change_unix'] = strtotime($row['last_change']).'000';
      }
    }
    return $result;
  }

  protected function doAfterInsert($result, $params, $post) {
    if($result['code'] == '200' && safe($result, 'id')) {
      $RequestSchoolConcept = CActiveRecord::model('RequestSchoolConcept');
      $RequestSchoolConcept ->user = $this->user;
      $school_ids = Yii::app() -> db -> createCommand()
        -> select('prs.school_id')
        -> from('spi_project_school prs')
        -> join('spi_request req', 'req.project_id = prs.project_id')
        -> where('req.id=:id', array(':id' => $result['id']))
        -> queryColumn();

      foreach($school_ids as $school_id) {
        $data = array(
          'request_id' => $result['id'],
          'school_id'  => $school_id,
        );
        $RequestSchoolConcept->insert($data, true);
      }
    }
    return $result;
  }

  protected function doAfterUpdate($result, $params, $post, $id) {
    Yii::app()->db->createCommand()->update($this->table, array('last_change' => date("Y-m-d", time())), 'id=:id', array(':id' => $id ));
    if($this->school_concepts) {
      $RequestSchoolConcept = CActiveRecord::model('RequestSchoolConcept');
      $RequestSchoolConcept->user = $this->user;
      foreach ($this->school_concepts as $id=>$data) {
        $RequestSchoolConcept->update($id, $data);
      }
    }
    return $result;
  }

  protected function doAfterSelect($result) {

    if (isset($_GET['id'])){
      $row = $result['result'][0];

      $row['schools'] = Yii::app() -> db -> createCommand()
                                      -> select("sch.*
                                                , CONCAT(user.title, ' ' , user.first_name, ' ', user.last_name) user_name
                                                , user.function user_function")
                                      -> from('spi_project_school prj_sch')
                                      -> join( 'spi_school sch', 'prj_sch.school_id = sch.id' )
                                      -> join( 'spi_user user', 'user.id = sch.contact_id' )
                                      -> where('prj_sch.project_id=:id', array(':id' => $row['project_id']))
                                      -> queryAll();
      $result['result'] =  $row;
    }

    return $result;
  }

  protected function doBeforeUpdate($post, $id) {

    if(isset($post['finance_plan'])) {
      // ToDo: save data in property variable and save it data in method doAfterUpdate
      unset($post['finance_plan']);
    }

    if(isset($post['school_concepts'])) {
      $this->school_concepts = $post['school_concepts'];
      unset($post['school_concepts']);
    }

    if(isset($post['school_goals'])) {
      // ToDo: save data in property variable and save it data in method doAfterUpdate
      unset($post['school_goals']);
    }

    return array (
      'result' => true,
      'params' => $post,
      'post' => $post
    );

  }
}
