<?php
require_once ('utils/utils.php');
//require_once ('utils/responce.php');

class RequestLock extends BaseModel {
  public $table = 'spi_request_lock';
  public $select_all = ' * ';
  public $project_id = '';
  public $request_id = '';
  public $performer_id = '';

  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all) -> from($this -> table . ' tbl');
    
    $where = ' 1=1 ';
    $conditions = array();

    if ($where) {
      $command -> where($where, $conditions);
    }
    
    return $command;
  }



  protected function getParamCommand($command, array $params, array $logic = array()) {
    parent::getParamCommand($command, $params);
    $params = array_change_key_case($params, CASE_UPPER);
    if(safe($params, 'REQUEST_ID')) {
      $command -> andWhere("tbl.request_id = :request_id", array(':request_id' => $params['REQUEST_ID']));
    }
    return $command;
  }


  protected function doBeforeInsert($post) {
    if(isset($post['request_id'])){
      $this->request_id = $post['request_id'];

      $table = 'spi_request';
      $select_all = "
                        tbl.id request_id
                      , tbl.year
                      , tbl.start_date
                      , tbl.due_date
                      , tbl.last_change
                      , tbl.end_fill

                      , tbl.doc_target_agreement_id
                      , tbl.doc_request_id
                      , tbl.doc_financing_agreement_id

                      , tbl.additional_info
                      , tbl.senat_additional_info
                      , tbl.finance_comment
                      
                      , tbl.request_user_id
                      , CONCAT(IF(rqs_user.sex = 1, 'Herr', 'Frau' ), ' ' , rqs_user.first_name, ' ', rqs_user.last_name) request_user
                      , tbl.concept_user_id
                      , CONCAT(IF(cnp_user.sex = 1, 'Herr', 'Frau' ), ' ' , cnp_user.first_name, ' ', cnp_user.last_name) concept_user
                      , tbl.finance_user_id
                      , CONCAT(IF(fin_user.sex = 1, 'Herr', 'Frau' ), ' ' , fin_user.first_name, ' ', fin_user.last_name) finance_user

                      , bnk.contact_person
                      , bnk.iban
                      , bnk.bank_name
                      , bnk.description
                      , bnk.outer_id
                      , tbl.bank_details_id
                                            

                      , tbl.revenue_sum
                      , tbl.emoloyees_cost
                      , tbl.training_cost
                      , tbl.overhead_cost
                      , tbl.prof_association_cost
                      , tbl.total_cost

                      , prj.id project_id
                      , prj.code code

                      , prf.id performer_id
                      , CONCAT( 'Überpüft von ',
                          (SELECT CONCAT (u.first_name, ' ', u.last_name) name
                             FROM spi_user u
                            WHERE u.id = prf.checked_by), ' ',
                            DATE_FORMAT(prf.checked_date,'%d.%m.%Y')

                        ) performer_checked_by
                      , prf.short_name performer_name
                      , prf.name performer_long_name
                      , prf_user.function performer_contact_function
                      , CONCAT(IF(prf_user.sex = 1, 'Herr', 'Frau' ), ' ' , prf_user.first_name, ' ', prf_user.last_name) performer_contact

                      , dst.id district_id
                      , dst.name district_name
                      , CONCAT(IF(user.sex = 1, 'Herr', 'Frau' ), ' ' , user.first_name, ' ', user.last_name) district_contact

                      ";

      $command = Yii::app() -> db -> createCommand() -> select($select_all) -> from($table . ' tbl');
      $command -> join(     'spi_request_status rqs',     'tbl.status_id           = rqs.id' );
      $command -> join(     'spi_performer prf',          'tbl.performer_id        = prf.id' );
      $command -> leftJoin( 'spi_user prf_user',          'prf_user.id             = prf.representative_user_id' );
      $command -> join(     'spi_project prj',            'tbl.project_id          = prj.id' );
      $command -> leftJoin( 'spi_district dst',           'dst.id                  = prj.district_id' );
      $command -> leftJoin( 'spi_user user',              'user.id                 = dst.contact_id' );

      $command -> leftJoin( 'spi_bank_details bnk',              'bnk.id           = tbl.bank_details_id' );

      $command -> leftJoin( 'spi_user rqs_user',              'rqs_user.id         = tbl.request_user_id' );
      $command -> leftJoin( 'spi_user cnp_user',              'cnp_user.id         = tbl.concept_user_id' );
      $command -> leftJoin( 'spi_user fin_user',              'fin_user.id         = tbl.finance_user_id' );

      $command -> where('tbl.id=:id', array(':id' => $this->request_id ));
//      $result -> $command->text;
      $result = $command -> queryRow();



      if(!$result){
        return false;
      } else {
        $this->project_id = $result['project_id'];
        $this->performer_id = $result['performer_id'];
        $post=$result;
      }

//      print_r($result);
//      die();

    }
    return array (
      'result' => true,
      'params' => $post,
      'post' => $post
    );
  }



  protected function doAfterInsert($result, $params, $post) {
    //* start school info
    if($result['code'] == '200' && safe($result, 'id')) {

        $school_result = Yii::app() -> db -> createCommand()
                                        -> select("sch.number
                                                  ,sch.name
                                                  ,sch.id school_id
                                                  ,CONCAT(IF(user.sex = 1, 'Herr', 'Frau' ), ' ' , user.first_name, ' ', user.last_name)  user_name
                                                  , user.function user_function")
                                        -> from('spi_project_school prj_sch')
                                        -> join( 'spi_school sch', 'prj_sch.school_id = sch.id' )
                                        -> leftJoin( 'spi_user user', 'user.id = sch.contact_id' )
                                        -> where('prj_sch.project_id=:id', array(':id' => $this->project_id))

                                        -> queryAll();



      $SchoolLock = CActiveRecord::model('SchoolLock');
      $SchoolLock->user = $this->user;

      if($school_result){
        foreach($school_result as &$row) {
          $row['request_id'] = $this->request_id ;
          unset($row['id']);
          $SchoolLock->insert($row, true);
        }
      }
      //* end school info

      //* start bank info
      if($result['code'] == '200' && safe($result, 'id')) {

        $bank_result = Yii::app() -> db -> createCommand()
                                        -> select(" * ")
                                        -> from('spi_bank_details bnk')
                                        -> where('bnk.performer_id=:id', array(':id' => $this->performer_id))
                                        -> queryAll();



        $BankLock = CActiveRecord::model('BankLock');
        $BankLock->user = $this->user;

        if($bank_result){
          foreach($bank_result as &$row) {
            $row['request_id'] = $this->request_id ;
            $row['bank_details_id'] = $row['id'];
            unset($row['id']);
            $BankLock->insert($row, true);
          }
        }
      }
      //* end bank info

      //* start user info
      if($result['code'] == '200' && safe($result, 'id')) {

        $user_result = Yii::app() -> db -> createCommand()
                                        -> select(" * ")
                                        -> from('spi_user bnk')
                                        -> where('bnk.relation_id=:id', array(':id' => $this->performer_id))
                                        -> queryAll();



        $UserLock = CActiveRecord::model('UserLock');
        $UserLock->user = $this->user;

        if($user_result){
          foreach($user_result as &$row) {
            $row['user_id'] = $row['id'];
            $row['request_id'] = $this->request_id ;
            unset($row['id']);
            if(!isset($row['login']) && $row['login'] == null){
              $row['login'] = '';
            }
            $UserLock->insert($row, true);
          }
        }
      }
//* end user info
      return $result;
    }

  }

}


