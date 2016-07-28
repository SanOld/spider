<?php
require_once ('utils/utils.php');


class DocumentTemplate extends BaseModel {
  public $table = 'spi_document_template';
  public $post = array();
  public $select_all = ' tbl.*, type.name type_name, CONCAT(user.first_name, " ", user.last_name ) user_name ';

  public $requestData = array();
  public $performerData = array();
  public $performerUsers = array();
  public $performerRepresentativeUser = array();
  public $requestConceptUser = array();
  public $requestFinanceUser = array();
  public $requestSchoolFinance = array();
  public $requestSchoolConcept = array();
  public $requestSchoolGoal = array();
  public $finPlanUsers = array();
  public $bankDetails = array();
  public $districtData = array();
  public $profAssociation = array();
  public $goals = array();


  protected function getCommand() {
    $command = Yii::app() -> db -> createCommand() -> select($this->select_all)
      -> from($this -> table . ' tbl')
      -> join('spi_document_template_type type', 'tbl.type_id = type.id')
      -> leftJoin('spi_user user', 'tbl.user_id = user.id');

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
    $command = $this->setLikeWhere($command,array('tbl.name', 'type.name'),safe($params, 'KEYWORD'));
    if (isset($params['TYPE_ID'])) {
      $command -> andWhere("tbl.type_id = :type_id", array(':type_id' => $params['TYPE_ID']));
    }
    if (isset($params['IDS'])) {
      $command -> andWhere(array('in', 'tbl.id', $params['IDS']));
    }
    return $command;
  }

  protected function doBeforeInsert($post) {

    $post['user_id'] = $this->user['id'];
       
    $post['type_code'] = Yii::app() -> db -> createCommand() -> select('code') -> from('spi_document_template_type') -> where('id=:id ', array(
        ':id' => $post['type_id']
    )) ->queryScalar();

    return array(
      'result' => true,
      'params' => $post
    );
  }

  protected function doBeforeUpdate($post, $id) {

    $post['user_id'] = $this->user['id'];
    $post['last_change'] = date('c', time());
    
    if(safe($post,'type_id')) {
      $post['type_code'] = Yii::app() -> db -> createCommand() -> select('code') -> from('spi_document_template_type') -> where('id=:id ', array(
          ':id' => $post['type_id']
      )) -> queryScalar();
    }
    
    return array(
      'result' => true,
      'params' => $post
    );

  }


  protected function calcResults($result) {
    if(safe($_GET, 'prepare') == '1' && safe($_GET, 'request_id')) {

      $Request = CActiveRecord::model('Request');
      $Request->user = $this->user;
      $requestInfo = $Request->select(array('id' => safe($_GET, 'request_id')), true);
      $this->requestData = $requestInfo['result'][0];

      $requestTableData = Yii::app() -> db -> createCommand() -> select("*, DATE_FORMAT(start_date,'%d.%m.%Y') start_date_formated,  DATE_FORMAT(due_date,'%d.%m.%Y') due_date_formated") -> from('spi_request') -> where('id=:id ', array(':id' => safe($_GET, 'request_id'))) -> queryRow();
      $this->performerData = Yii::app() -> db -> createCommand() -> select('*') -> from('spi_performer') -> where('id=:id ', array(':id' => $this->requestData['performer_id'])) -> queryRow();


      /*start performerUsers*/
      if ($this->requestData['status_id' == '5']){
        $Request = CActiveRecord::model('UserLock');
        $Request->user = $this->user;
        $requestInfo = $Request->select(array('relation_id' => $this->requestData['performer_id']
                                              , 'request_id' => $this->requestData['id']
                                              , 'type' => 't'
                                                ), true);
        $this->performerUsers = $requestInfo['result'];
      } else {
        $Request = CActiveRecord::model('User');
        $Request->user = $this->user;
        $requestInfo = $Request->select(array('relation_id' => $this->requestData['performer_id'],
                                        'type' => 't'
                                        ), true);

        $this->performerUsers = $requestInfo['result'];
      }
      foreach ($this->performerUsers as $key=>$value){
        $this->performerUsers[$key]['user_id'] = $this->performerUsers[$key]['id'];
        if($this->performerUsers[$key]['sex'] == 1){
          $this->performerUsers[$key]['gender'] = 'Herr';
        }
        if($this->performerUsers[$key]['sex'] == 2){
          $this->performerUsers[$key]['gender'] = 'Frau';
        }

        if($this->performerUsers[$key]['user_id'] == $this->requestData['concept_user_id']){
          $this->requestConceptUser = $this->performerUsers[$key];
        }
        if($this->performerUsers[$key]['user_id'] == $this->requestData['finance_user_id']){
          $this->requestFinanceUser = $this->performerUsers[$key];
        }
        if($this->performerUsers[$key]['user_id'] == $this->performerData['representative_user_id']){
          $this->performerRepresentativeUser = $this->performerUsers[$key];
        }
      }
      /*end performerUsers*/

      /*start finance information*/
          /*start finPlanUsers*/
          $Request = CActiveRecord::model('RequestUser');
          $Request->user = $this->user;
          $requestInfo = $Request->select(array('request_id' => $this->requestData['id']), true);
          $this->finPlanUsers = $requestInfo['result'];
          /*end finPlanUsers*/

          /*start request_school_finance*/
          $Request = CActiveRecord::model('RequestSchoolFinance');
          $Request->user = $this->user;
          $requestInfo = $Request->select(array('request_id' => safe($_GET, 'request_id')), true);
          $this->requestSchoolFinance = $requestInfo['result'];
          /*end request_school_finance*/




          /*start BankDetails*/
          $Request = CActiveRecord::model('BankDetails');
          $Request->user = $this->user;
          $requestInfo = $Request->select(array('performer_id' => $this->requestData['performer_id'] ), true);
          $this->bankDetails = $requestInfo['result'];
          /*end BankDetails*/

          /*start RequestProfAssociation*/
          $Request = CActiveRecord::model('RequestProfAssociation');
          $Request->user = $this->user;
          $requestInfo = $Request->select(array('request_id' => $this->requestData['id']), true);
          $this->profAssociation = $requestInfo['result'];
          /*end RequestProfAssociation*/

      /*end finance information*/

      /*start District*/
      $district_id = Yii::app()->db->createCommand()->select('district_id')->from('spi_project')->where('id=:id', array(':id' => $this->requestData['project_id']))->queryScalar();
      $Request = CActiveRecord::model('District');
      $Request->user = $this->user;
      $requestInfo = $Request->select(array('id' => $district_id ), true);
      $this->districtData = $requestInfo['result'][0];
      /*end District*/

      /*start request_school_concept*/
      $Request = CActiveRecord::model('RequestSchoolConcept');
      $Request->user = $this->user;
      $requestInfo = $Request->select(array('request_id' => safe($_GET, 'request_id')), true);
      $this->requestSchoolConcept = $requestInfo['result'];
      /*end request_school_concept*/

      /*start request_school_goal*/
      $Request = CActiveRecord::model('RequestSchoolGoal');
      $Request->user = $this->user;
      $requestInfo = $Request->select(array('request_id' => safe($_GET, 'request_id')), true);
      $this->requestSchoolGoal = $requestInfo['result'];
      /*end request_school_goal*/



      foreach($result['result'] as &$row) {
        $row['text'] = $this->prepareText($row['text']);
      }
    }
    return $result;
  }

  protected function prepareText($text) {
    $text = $this->prepareProjectData($text);
    $text = $this->prepareFinanceData($text);
    $text = $this->prepareConceptData($text);
    $text = $this->prepareGoalsData($text);
    return $text;
  }

  private function prepareProjectData($text){

    $text = preg_replace_callback("/\{FOREACH=SCHOOL\}.+\{FOREACH_END=SCHOOL\}/is", array($this, 'repeatSchools'), $text);

    $params = array(
          '{AUFLAGEN}'      => $this->requestData['senat_additional_info']
        , '{FOERDERSUMME}'  => $this->requestData['total_cost']
        , '{JAHR}'          => $this->requestData['year']
        , '{KENNZIFFER}'    => Yii::app()->db->createCommand()->select('code')->from('spi_project')->where('id=:id', array(':id' => $this->requestData['project_id']))->queryScalar()
        , '{ZEITRAUM}'      => 'Beginn: '.$this->requestData['start_date_formated'].' Ende: '.$this->requestData['due_date_formated']
        , '{TRAEGER}'       => $this->performerData['name']

        , '{PD_TRAGER_ADRESSE}'   => $this->performerData['address']
        , '{PD_TRAEGER_PLZ}'      => $this->performerData['plz']
        , '{PD_TRAEGER_Stadt}'    => $this->performerData['city']
        , '{PD_TRAEGER_Telefon}'  => $this->performerData['phone']
        , '{PD_TRAEGER_Telefax}'  => $this->performerData['fax']
        , '{PD_TRAEGER_Homepage}' => $this->performerData['homepage']
        , '{PD_TRAEGER_Email}'    => $this->performerData['email']
            
        , '{PD_Vertretungsberechtigte_Anrede}'   => $this->performerRepresentativeUser['gender']
        , '{PD_Vertretungsberechtigte_Function}' => $this->performerRepresentativeUser['function']
        , '{PD_Vertretungsberechtigte_Vorname}'  => $this->performerRepresentativeUser['first_name']
        , '{PD_Vertretungsberechtigte_Nachname}' => $this->performerRepresentativeUser['last_name']

        , '{PD_Konzept_Anrede}'   => $this->requestConceptUser['gender']
        , '{PD_Konzept_Function}' => $this->requestConceptUser['function']
        , '{PD_Konzept_Vorname}'  => $this->requestConceptUser['first_name']
        , '{PD_Konzept_Nachname}' => $this->requestConceptUser['last_name']
        , '{PD_Konzept_Telefon}'  => $this->requestConceptUser['phone']
        , '{PD_Konzept_Email}'    => $this->requestConceptUser['email']

        , '{PD_Finance_Anrede}'   => $this->requestFinanceUser['gender']
        , '{PD_Finance_Function}' => $this->requestFinanceUser['function']
        , '{PD_Finance_Vorname}'  => $this->requestFinanceUser['first_name']
        , '{PD_Finance_Nachname}' => $this->requestFinanceUser['last_name']
        , '{PD_Finance_Telefon}'  => $this->requestFinanceUser['phone']
        , '{PD_Finance_Email}'    => $this->requestFinanceUser['email']

        , '{PD_Bank_Contact}' => $this->bankDetails['contact_person']
        , '{PD_Bank_Name}'    => $this->bankDetails['bank_name']
        , '{PD_Bank_Outer}'   => $this->bankDetails['outer_id']
        , '{PD_Bank_Descr}'   => $this->bankDetails['description']
        , '{PD_Bank_IBAN}'    => $this->bankDetails['iban']

        , '{PD_District_Bezirk}'          => $this->districtData['name']
        , '{PD_District_PLZ}'             => $this->districtData['plz']
        , '{PD_District_Stadt}'           => $this->districtData['city']
        , '{PD_District_Straße}'          => $this->districtData['address']
        , '{PD_District_Telefon}'         => $this->districtData['phone']
        , '{PD_District_Telefax}'         => $this->districtData['fax']
        , '{PD_District_Email}'           => $this->districtData['email']
        , '{PD_District_Homepage}'        => $this->districtData['homepage']
        , '{PD_District_Address}'         => $this->districtData['full_address']


      );

    return $this->doReplace($text,$params);
  }
  private function repeatSchools($data){
    $text = array();
    foreach ($this->requestData['schools'] as $key => $school) {
      $params = array(
          '{FOREACH=SCHOOL}'     => '',
          '{FOREACH_END=SCHOOL}' => '',
          '{PD_SCHOOLNAME}'      => $school['name'],
          '{PD_SCHOOLNUMBER}'    => $school['number'],
        );
      $text[] = $this->doReplace($data[0],$params);
    }
    $text = implode('<br>', $text);
    return $text;
  }

  private function prepareFinanceData($text){
//    var_dump($text);
    $text = preg_replace_callback("/\{FOREACH=PERSONALKOSTEN\}.+\{FOREACH_END=PERSONALKOSTEN\}/is", array($this, 'repeatFinUsers'), $text);
    $text = preg_replace_callback("/\{FOREACH=SACHKOSTEN\}.+\{FOREACH_END=SACHKOSTEN\}/is", array($this, 'repeatSchoolFinance'), $text);

    $params = array(
                    '{FD_revenue_sum}'           => $this->requestData['revenue_sum']
                  , '{FD_emoloyees_cost}'        => $this->requestData['emoloyees_cost']
                  , '{FD_training_cost}'         => $this->requestData['training_cost']
                  , '{FD_overhead_cost}'         => $this->requestData['overhead_cost']
                  , '{FD_prof_association_cost}' => $this->requestData['prof_association_cost']
                  , '{FD_total_cost}'            => $this->requestData['total_cost']
                );

    return $this->doReplace($text,$params);
  }
  private function repeatFinUsers($data){
    $text = array();
    foreach ($this->finPlanUsers as $key => $user) {
      $user_info = Yii::app() -> db -> createCommand()
                                      -> select("CONCAT(IF(user.sex = 1, 'Herr', 'Frau' ), ' ' , user.first_name, ' ', user.last_name)  user_name
                                                , user.function user_function")
                                      -> from('spi_user user')
                                      -> where('id=:id', array(':id' => $user['user_id']))
                                      -> queryRow();
      $params = array(
                      '{FOREACH=PERSONALKOSTEN}'           => ''
                    , '{FOREACH_END=PERSONALKOSTEN}'       => ''

                    , '{FD_USERNAME}'                      => $user_info['user_name']
                    , '{FD_USERFUNCTION}'                  => $user_info['user_function']

                    , '{FD_other}'                         => $user['other']
                    , '{FD_cost_per_month_brutto}'         => $user['cost_per_month_brutto']
                    , '{FD_month_count}'                   => $user['month_count']
                    , '{FD_hours_per_week}'                => $user['hours_per_week']
                    , '{FD_have_annual_bonus}'             => $user['have_annual_bonus']
                    , '{FD_annual_bonus}'                  => $user['annual_bonus']
                    , '{FD_have_additional_provision_vwl}' => $user['have_additional_provision_vwl']
                    , '{FD_additional_provision_vwl}'      => $user['additional_provision_vwl']
                    , '{FD_have_supplementary_pension}'    => $user['have_supplementary_pension']
                    , '{FD_supplementary_pension}'         => $user['supplementary_pension']
                    , '{FD_brutto}'                        => $user['brutto']
                    , '{FD_add_cost}'                      => $user['add_cost']
                    , '{FD_full_cost}'                     => $user['full_cost']
                  );
      
      $text[] = $this->doReplace($data[0],$params);
    }
    $text = implode('<br>', $text);
    return $text;
  }  
  private function repeatSchoolFinance($data){
    $text = array();
    foreach ($this->requestSchoolFinance as $key => $school) {
      $params = array(
            '{FOREACH=SACHKOSTEN}'  => ''
          , '{FOREACH_END=SACHKOSTEN}'         => ''
          , '{FD_SCHOOLNAME}'          => $school['school_name']
          , '{FD_SCHOOLNUMBER}'        => $school['school_number']

          , '{FD_Stellenanteil}'       => $school['rate']
          , '{FD_Monat}'               => $school['month_count']
          , '{FD_Fortbildungskosten}'  => $school['training_cost']
          , '{FD_Regiekosten}'         => $school['overhead_cost']
        );

      $text[] = $this->doReplace($data[0],$params);
    }
    $text = implode('<br>', $text);
    return $text;
  }

  private function prepareConceptData($text){
    $text = preg_replace_callback("/\{FOREACH=CONCEPT\}.+\{FOREACH_END=CONCEPT\}/is", array($this, 'repeatSchoolConcept'), $text);
    return $text;
  }
  private function repeatSchoolConcept($data){
    $text = array();
    foreach ($this->requestSchoolConcept as $key => $school) {
      $params = array(
            '{FOREACH=CONCEPT}'  => ''
          , '{FOREACH_END=CONCEPT}'         => ''
          , '{CD_SCHOOLNAME}'       => $school['school_name']
          , '{CD_SCHOOLNUMBER}'     => $school['school_number']

          , '{CD_Situation}'        => $school['situation']
          , '{CD_Angebote}'         => $school['offers_youth_social_work']
        );

      $text[] = $this->doReplace($data[0],$params);
    }
    $text = implode('<br>', $text);
    return $text;
  }

  private function prepareGoalsData($text){
    $text = preg_replace_callback("/\{FOREACH=SCHOOLGOAL\}[\d\D]+\{FOREACH_END=SCHOOLGOAL\}/is", array($this, 'repeatSchoolGoal'), $text);
    return $text;
  }
  private function repeatSchoolGoal($data){
    $text = array();
    foreach ($this->requestSchoolGoal as $key => $school) {
      $this->goals = $school['goals'];

      $withGoal = preg_replace_callback("/\{FOREACH=GOAL\}.+\{FOREACH_END=GOAL\}/is", array($this, 'repeatGoal'), $data[0]);

      $params = array(
            '{FOREACH=SCHOOLGOAL}'      => ''
          , '{FOREACH_END=SCHOOLGOAL}'  => ''
          , '{GD_SCHOOLNAME}'           => $school['school_name']
          , '{GD_SCHOOLNUMBER}'         => $school['school_number']
        );

      $text[] = $this->doReplace($withGoal,$params);
    }
    $text = implode('<br>', $text);
    return $text;
  }
  private function repeatGoal($data){
    $text = array();
    $groupOffer_priorityGoal = '';
    $groupOffer_plainGoal = '';
    $groupOffer = array(
          'capacity' => 'Verbesserung der (vorberuflichen) Handlungskompetenzen'
        , 'transition' => 'Verbesserung aller Übergänge in Schule (Kita-GS-Sek I-Sek II) und in Aus'
        , 'reintegration' => 'Abbau von Schuldistanz; Reintegration in den schulischen Alltag'
        , 'social_skill' => 'Stärkung der sozialen Kompetenzen und des Selbstvertrauen'
        , 'prevantion_violence' => 'Gewaltprävention und -intervention'
        , 'health' => 'Gesundheitsförderung'
        , 'sport' => 'Förderung sportlicher, kultureller und sportlicher Interessen'
        , 'parent_skill' => 'Einbindung der Eltern und Stärkung der Erziehungskompetenzen'
        , 'other_goal' => 'Sonstiges (Bezug in extra Textfeld benennen)'
    );

    $groupNet = array(
          'cooperation' => 'Zusammenarbeit im Tandem oder Tridem'
        , 'participation' => 'Mitarbeit in schulischen Gremien, Treffen mit Schulleitung, Mitwirkung in AGs'
        , 'social_area' => 'Öffnung der Schule in den Sozialraum'
        , 'third_part' => 'Einbindung des Sozialraums bzw. Angebote Dritter in die Schule'
        , 'regional' => 'Mitarbeit in regionalen Arbeitsgemeinschaften / Netzwerken'
        , 'concept' => 'Gemeinsame Handlungs- und Bildungskonzepte'
        , 'net_other_goal' => 'Sonstiges (Bezug in extra Textfeld benennen)'
    );

    foreach ($this->goals as $key => $goal) {
      if($goal['description'] == ''){
        continue;
      }
      $groupNet_priorityGoal = '';
      $groupNet_plainGoal = '';
      $groupOffer_priorityGoal = '';
      $groupOffer_plainGoal = '';


      foreach($groupNet as $groupKey=>$groupValue){
        if($goal[$groupKey] == '1'){
          $groupNet_priorityGoal .= $groupValue.'<br>';
        } else if($goal[$groupKey] == '2'){
          $groupNet_plainGoal .= $groupValue.'<br>';
        }
      }


      foreach($groupOffer as $groupKey=>$groupValue){
        if($goal[$groupKey] == '1'){
          $groupOffer_priorityGoal .= $groupValue.'<br>';
        } else if($goal[$groupKey] == '2'){
          $groupOffer_plainGoal .= $groupValue.'<br>';
        }
      }
      
      $params = array(
            '{FOREACH=GOAL}'                  => ''
          , '{FOREACH_END=GOAL}'              => ''
          , '{GD_name}'                       => $goal['name']
          , '{GD_description}'                => $goal['description']

          , '{GD_groupOffer_Schwerpunktziel}' => $groupOffer_priorityGoal
          , '{GD_groupOffer_WeiteresZiel}'    => $groupOffer_plainGoal
          , '{GD_groupOffer_other}'           => $goal['other_description']

          , '{GD_groupNet_Schwerpunktziel}'   => $groupNet_priorityGoal
          , '{GD_groupNet_WeiteresZiel}'      => $groupNet_plainGoal
          , '{GD_groupNet_other}'             => $goal['network_text']
              
          , '{GD_Umsetzung}'                  => $goal['implementation']

          , '{GD_Indikatoren1}'               => $goal['indicator_1']
          , '{GD_Indikatoren2}'               => $goal['indicator_2']
          , '{GD_Indikatoren3}'               => $goal['indicator_3']
          , '{GD_Indikatoren4}'               => $goal['indicator_4']
          , '{GD_Indikatoren5}'               => $goal['indicator_5'] 

        );

      $text[] = $this->doReplace($data[0],$params);
    }
    if(count($text) > 0){
      $text = implode('<br>', $text);
    } else {
      $text = '';
    }
    
    return $text;
  }

  private function doReplace($_text, $params){
    $text = $_text;
    if($text && $text != '') {
      $data = array();
      $placeholders = array();
      foreach($params as $key=>$val) {
        $data[] = $val;
        $placeholders[] = $key;
      }
      $text = str_replace($placeholders, $data, $text);
      return $text;
    }
    return '';
  }

}