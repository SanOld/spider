<?php
require_once ('utils/utils.php');


class DocumentTemplate extends BaseModel {
  public $table = 'spi_document_template';
  public $post = array();
  public $select_all = ' tbl.*, type.name type_name, CONCAT(user.first_name, " ", user.last_name ) user_name ';

  public $requestData = array();
  public $finRequestData = array();
  public $projectData = array();
  public $bankData = array();
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
    if (isset($params['PAYMENT_ID'])) {
      $command -> join ('spi_payment_type ptp', 'type.id = ptp.template_type_id');
      $command -> andWhere("ptp.id = :payment_id", array(':payment_id' => $params['PAYMENT_ID']));
    }
    $command = $this->setWhereByRole($command);
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

//      $requestTableData = Yii::app() -> db -> createCommand() -> select("*, DATE_FORMAT(start_date,'%d.%m.%Y') start_date_formated,  DATE_FORMAT(due_date,'%d.%m.%Y') due_date_formated") -> from('spi_request') -> where('id=:id ', array(':id' => safe($_GET, 'request_id'))) -> queryRow();
      $this->performerData = Yii::app() -> db -> createCommand() -> select('*') -> from('spi_performer') -> where('id=:id ', array(':id' => $this->requestData['performer_id'])) -> queryRow();

      /*start performerUsers*/

      /*start District*/
      $district_id = Yii::app()->db->createCommand()->select('district_id')->from('spi_project')->where('id=:id', array(':id' => $this->requestData['project_id']))->queryScalar();
      $Request = CActiveRecord::model('District');
      $Request->user = $this->user;
      $requestInfo = $Request->select(array('id' => $district_id ), true);
      $this->districtData = $requestInfo['result'][0];
      /*end District*/


      if ($this->requestData['status_id'] == '5' || $this->requestData['status_id'] == '4'){

        $this->performerData['name'] = $this->requestData['performer_long_name'];
        $this->districtData['name'] = $this->requestData['district_name'];

        
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

        if ($this->requestData['status_id'] != '5' && $this->requestData['status_id'] != '4'){
          $this->performerUsers[$key]['user_id'] = $this->performerUsers[$key]['id'];
        }

        switch ($this->performerUsers[$key]['sex']) {
          case 1:
          $this->performerUsers[$key]['gender'] = 'Herr';
            break;
          case 2:
          $this->performerUsers[$key]['gender'] = 'Frau';
            break;
          default:
            $this->performerUsers[$key]['gender']='';
            break;
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

            $requestInfo = $Request->select(array('id' => $this->requestData['bank_details_id'] ), true);
            $this->bankDetails = $requestInfo['result'][0];
            /*end BankDetails*/

          /*start RequestProfAssociation*/
          $Request = CActiveRecord::model('RequestProfAssociation');
          $Request->user = $this->user;
          $requestInfo = $Request->select(array('request_id' => $this->requestData['id']), true);

          $this->profAssociation = $requestInfo['result'][0];
          /*end RequestProfAssociation*/
        /*end finance information*/ 



      /*start request_school_concept*/
      $Request = CActiveRecord::model('RequestSchoolConcept');
      $Request->user = $this->user;
      $requestInfo = $Request->select(array('request_id' => safe($_GET, 'request_id')), true);
      $this->requestSchoolConcept = $requestInfo['result'];
      /*end request_school_concept*/

      /*start request_school_ */
      $Request = CActiveRecord::model('RequestSchoolGoal');
      $Request->user = $this->user;
      $requestInfo = $Request->select(array('request_id' => safe($_GET, 'request_id')), true);
      $this->requestSchoolGoal = $requestInfo['result'];
      /*end request_school_goal*/

      foreach($this->requestData['schools'] as $key=>$value) {
        $this->requestData['schools'][$key] = array_merge($this->requestData['schools'][$key]
                                                      , $this->requestSchoolFinance[$key]
                                                      , $this->requestSchoolConcept[$key]
                                                      , $this->requestSchoolGoal[$key]
                );
      }

      foreach($result['result'] as &$row) {
        $row['text'] = $this->prepareText($row['text']);
      }
    }
    if(safe($_GET, 'prepare_fin_request') && safe($_GET, 'fin_request_id')){
      $FinRequest = CActiveRecord::model('FinancialRequest');      
      $FinRequest->user = $this->user;
      $finRequestInfo = $FinRequest->select(array('id' => safe($_GET, 'fin_request_id')), true);
      $this->finRequestData = $finRequestInfo['result'][0];      
      
      $this->requestData = Yii::app() -> db -> createCommand()
                             -> select('*') -> from('spi_request') 
                             -> where('id=:id ', array(':id' => $this->finRequestData['request_id'])) -> queryRow();     
      
      $this->performerData = Yii::app() -> db -> createCommand()
                             -> select('*') -> from('spi_performer') 
                             -> where('id=:id ', array(':id' => $this->requestData['performer_id'])) -> queryRow();
      
      $Bank = CActiveRecord::model('BankDetails');
      $Bank->user = $this->user;
      $bankInfo = $Bank->select(array('id' => $this->finRequestData['bank_account_id']), true);      
      $this->bankData = $bankInfo['result'][0];      
      
      foreach($result['result'] as &$row) {
        $row['text'] = $this->prepareText($row['text']);
      }
    }
    return $result;
  }

  protected function prepareText($text) {
    $text = $this->prepareProjectData($text);
    $text = $this->prepareFinanceData($text);
    if(safe($_GET,'fin_request_id')){
      $text = $this->prepareFinancialRequestData($text);
    };
//    $text = $this->prepareConceptData($text);
//    $text = $this->prepareGoalsData($text);
    return $text;
  }

  private function prepareProjectData($text){

    $text = preg_replace_callback("/\{FOREACH=SCHOOL KEY=SC\}.+\{FOREACH_END=SCHOOL\}/is", array($this, 'repeatSchools'), $text);

    $params = array(
          '{AUFLAGEN}'      => safe($this->requestData,'senat_additional_info') ? $this->requestData['senat_additional_info'] : ''
        , '{FOERDERSUMME}'  => $this->requestData['total_cost']
        , '{JAHR}'          => $this->requestData['year']
        , '{KENNZIFFER}'    => Yii::app()->db->createCommand()->select('code')->from('spi_project')->where('id=:id', array(':id' => $this->requestData['project_id']))->queryScalar()
        , '{ZEITRAUM}'      => 'Beginn: '.$this->requestData['start_date'].' Ende: '.$this->requestData['due_date']
        , '{TRAEGER}'       => $this->performerData['name']
     );


    if($this->performerData){
      $data = array(
          '{PD_TRAGER_ADRESSE}'   => safe($this->performerData,'address') ? $this->performerData['address'] : ''
        , '{PD_TRAEGER_PLZ}'      => safe($this->performerData,'plz') ? $this->performerData['plz'] : ''
        , '{PD_TRAEGER_STADT}'    => safe($this->performerData,'city') ? $this->performerData['city'] : ''
        , '{PD_TRAEGER_TELEFON}'  => safe($this->performerData,'phone') ? $this->performerData['phone'] : ''
        , '{PD_TRAEGER_TELEFAX}'  => safe($this->performerData,'fax') ? $this->performerData['fax'] : ''
        , '{PD_TRAEGER_HOMEPAGE}' => safe($this->performerData,'homepage') ? $this->performerData['homepage'] : ''
        , '{PD_TRAEGER_EMAIL}'    => safe($this->performerData,'email') ? $this->performerData['email'] : ''
      );
      $params = array_merge($params,$data);
    }
            
    if($this->performerRepresentativeUser){
      $data = array(
          '{PD_VERTRETUNGSBERECHTIGTE_ANREDE}'   => safe($this->performerRepresentativeUser,'gender') ? $this->performerRepresentativeUser['gender'] : ''
        , '{PD_VERTRETUNGSBERECHTIGTE_FUNCTION}' => safe($this->performerRepresentativeUser,'function') ? $this->performerRepresentativeUser['function'] : ''
        , '{PD_VERTRETUNGSBERECHTIGTE_VORNAME}'  => safe($this->performerRepresentativeUser,'first_name') ? $this->performerRepresentativeUser['first_name'] : ''
        , '{PD_VERTRETUNGSBERECHTIGTE_NACHNAME}' => safe($this->performerRepresentativeUser,'last_name') ? $this->performerRepresentativeUser['last_name'] : ''
      );
      $params = array_merge($params,$data);
    }
    if($this->requestConceptUser){
      $data = array(
          '{PD_KONZEPT_ANREDE}'   => safe($this->requestConceptUser,'gender') ? $this->requestConceptUser['gender'] : ''
        , '{PD_KONZEPT_FUNCTION}' => safe($this->requestConceptUser,'function') ? $this->requestConceptUser['function'] : ''
        , '{PD_KONZEPT_VORNAME}'  => safe($this->requestConceptUser,'first_name') ? $this->requestConceptUser['first_name'] : ''
        , '{PD_KONZEPT_NACHNAME}' => safe($this->requestConceptUser,'last_name') ? $this->requestConceptUser['last_name'] : ''
        , '{PD_KONZEPT_TELEFON}'  => safe($this->requestConceptUser,'phone') ? $this->requestConceptUser['phone'] : ''
        , '{PD_KONZEPT_EMAIL}'    => safe($this->requestConceptUser,'email') ? $this->requestConceptUser['email'] : ''
      );
      $params = array_merge($params,$data);
    }
    if($this->requestFinanceUser){
      $data = array(
          '{PD_FINANCE_ANREDE}'   => safe($this->requestFinanceUser,'phone') ? $this->requestFinanceUser['phone'] : ''
        , '{PD_FINANCE_FUNCTION}' => safe($this->requestFinanceUser,'function') ? $this->requestFinanceUser['function'] : ''
        , '{PD_FINANCE_VORNAME}'  => safe($this->requestFinanceUser,'first_name') ? $this->requestFinanceUser['first_name'] : ''
        , '{PD_FINANCE_NACHNAME}' => safe($this->requestFinanceUser,'last_name') ? $this->requestFinanceUser['last_name'] : ''
        , '{PD_FINANCE_TELEFON}'  => safe($this->requestFinanceUser,'phone') ? $this->requestFinanceUser['phone'] : ''
        , '{PD_FINANCE_EMAIL}'    => safe($this->requestFinanceUser,'email') ? $this->requestFinanceUser['email'] : ''
      );
      $params = array_merge($params,$data);
    }
    if($this->bankDetails){
      $data = array(
          '{PD_BANK_CONTACT}' => safe($this->bankDetails,'contact_person') ? $this->bankDetails['contact_person'] : ''
        , '{PD_BANK_NAME}'    => safe($this->bankDetails,'bank_name') ? $this->bankDetails['bank_name'] : ''
        , '{PD_BANK_OUTER}'   => safe($this->bankDetails,'outer_id') ? $this->bankDetails['outer_id'] : ''
        , '{PD_BANK_DESCR}'   => safe($this->bankDetails,'description') ? $this->bankDetails['description'] : ''
        , '{PD_BANK_IBAN}'    => safe($this->bankDetails,'iban') ? $this->bankDetails['iban'] : ''
      );
      $params = array_merge($params,$data);
    }
    if($this->districtData){
      $data = array(
          '{PD_DISTRICT_BEZIRK}'          => safe($this->districtData,'iban') ? $this->districtData['name'] : ''
        , '{PD_DISTRICT_PLZ}'             => safe($this->districtData,'plz') ? $this->districtData['plz'] : ''
        , '{PD_DISTRICT_STADT}'           => safe($this->districtData,'city') ? $this->districtData['city'] : ''
        , '{PD_DISTRICT_ADRESSE}'         => safe($this->districtData,'address') ? $this->districtData['address'] : ''
        , '{PD_DISTRICT_TELEFON}'         => safe($this->districtData,'phone') ? $this->districtData['phone'] : ''
        , '{PD_DISTRICT_TELEFAX}'         => safe($this->districtData,'fax') ? $this->districtData['fax'] : ''
        , '{PD_DISTRICT_EMAIL}'           => safe($this->districtData,'email') ? $this->districtData['email'] : ''
        , '{PD_DISTRICT_HOMEPAGE}'        => safe($this->districtData,'homepage') ? $this->districtData['homepage'] : ''
        , '{PD_DISTRICT_ADDRESS}'         => safe($this->districtData,'full_address') ? $this->districtData['full_address'] : ''
      );
      $params = array_merge($params,$data);
    } 

    return $this->doReplace($text,$params);
  }
  private function repeatSchools($data){
    $text = array();
    foreach ($this->requestData['schools'] as $key => $school) {

      $this->goals = $school['goals'];
      $withGoal = preg_replace_callback("/\{FOREACH=GOAL KEY=GD\}.+\{FOREACH_END=GOAL\}/is", array($this, 'repeatGoal'), $data[0]);

      $params = array(
          '{FOREACH=SCHOOL KEY=SC}'    => ''
          ,'{FOREACH_END=SCHOOL}'      => ''

          , '{SC_SCHOOLNAME}'           => $school['name']
          , '{SC_SCHOOLNUMBER}'         => $school['number']

          , '{SC_STELLENANTEIL}'       => $school['rate']
          , '{SC_MONAT}'               => $school['month_count']
          , '{SC_FORTBILDUNGSKOSTEN}'  => $school['training_cost']
          , '{SC_REGIEKOSTEN}'         => $school['overhead_cost']

          , '{SC_SITUATION}'           => $school['situation']
          , '{SC_ANGEBOTE}'            => $school['offers_youth_social_work']

        );
      $text[] = $this->doReplace($withGoal,$params);
    }
    $text = implode('<br>', $text);
    return $text;
  }

  private function prepareFinanceData($text){
//    var_dump($text);
    $text = preg_replace_callback("/\{FOREACH=PERSONALKOSTEN KEY=PK\}.+\{FOREACH_END=PERSONALKOSTEN\}/is", array($this, 'repeatFinUsers'), $text);
//    $text = preg_replace_callback("/\{FOREACH=SACHKOSTEN\}.+\{FOREACH_END=SACHKOSTEN\}/is", array($this, 'repeatSchools'), $text);

    $params = array(
                    '{FD_REVENUE_SUM}'           => safe($this->requestData,'revenue_sum') ? $this->requestData['revenue_sum'] : ''
                  , '{FD_EMOLOYEES_COST}'        => safe($this->requestData,'emoloyees_cost') ? $this->requestData['emoloyees_cost'] : ''
                  , '{FD_TRAINING_COST}'         => safe($this->requestData,'training_cost') ? $this->requestData['training_cost'] : ''
                  , '{FD_OVERHEAD_COST}'         => safe($this->requestData,'overhead_cost') ? $this->requestData['overhead_cost'] : ''
                  , '{FD_PROF_ASSOCIATION_COST}' => safe($this->requestData,'prof_association_cost') ? $this->requestData['prof_association_cost'] : ''
                  , '{FD_TOTAL_COST}'            => safe($this->requestData,'total_cost') ? $this->requestData['total_cost'] : ''
                );

    return $this->doReplace($text,$params);
  }  
  private function prepareFinancialRequestData($text){
    $date = $this->finRequestData['receipt_date'];
    $day = substr($date, 8,2);
    $month = substr($date, 5,2);
    $year = substr($date, 0,4);
    $date = substr($date, 8,2).'-'.substr($date, 5,2).'-'.substr($date, 0,4);
    
    $request_cost = $this->finRequestData['request_cost'];
    $request_cost = str_replace('.', ',', $request_cost);
    $rate = Yii::app()->db->createCommand()->select('name')->from('spi_rate')->where('id=:id', array(':id' => $this->finRequestData['rate_id']))->queryScalar();
    
    $params = array(
                    '{TRAEGERADRESSE}'           => safe($this->performerData,'address') ? $this->performerData['address'] : ''
                  , '{KONTOVERBINDUNG}'          => "Bank: ".safe($this->bankData,'bank_name') ? $this->bankData['bank_name'] : ''."<br> IBAN: ". safe($this->bankData,'iban') ? $this->bankData['iban'] : ''
                  //, '{KONTO}'                    => $this->bankData
                  //, '{BLZ}'                      => $this->bankData['']
                  , '{KREDITOR}'                 => safe($this->bankData,'bank_name') ? $this->bankData['bank_name'] : ''
                  , '{IBAN}'                     => safe($this->bankData,'iban') ? $this->bankData['iban'] : ''
                  , '{BELEGDATUM MITTELABRUF}'   => $date
                  , '{RATE MITTELABRUF}'         => !safe($this->finRequestData,'is_partial_rate') ? $rate == '0' ? '-' : $rate : $this->finRequestData['is_partial_rate']
                  , '{BETRAG MITTELABRUF}'       => $request_cost
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
                      '{FOREACH=PERSONALKOSTEN KEY=PK}'    => ''
                    , '{FOREACH_END=PERSONALKOSTEN}'       => ''

                    , '{PK_USERNAME}'                      => safe($user_info,'user_name') ? $user_info['user_name'] : ''
                    , '{PK_USERFUNCTION}'                  => safe($user_info,'user_function') ? $user_info['user_function'] : ''

                    , '{PK_KOSTEN_PRO_JAHR_BRUTTO}'        => safe($user,'brutto') ? $user['brutto'] : ''
                    , '{PK_KOSTEN_PRO_JAHR_ANTEIL}'        => safe($user,'add_cost') ? $user['add_cost'] : ''

                    , '{PK_OTHER}'                         => safe($user,'other') ? $user['other'] : ''
                    , '{PK_COST_PER_MONTH_BRUTTO}'         => safe($user,'cost_per_month_brutto') ? $user['cost_per_month_brutto'] : ''
                    , '{PK_MONTH_COUNT}'                   => safe($user,'month_count') ? $user['month_count'] : ''
                    , '{PK_HOURS_PER_WEEK}'                => safe($user,'hours_per_week') ? $user['hours_per_week'] : ''
                    , '{PK_HAVE_ANNUAL_BONUS}'             => safe($user,'have_annual_bonus') ? $user['have_annual_bonus'] : ''
                    , '{PK_ANNUAL_BONUS}'                  => safe($user,'annual_bonus') ? $user['annual_bonus'] : ''
                    , '{PK_HAVE_ADDITIONAL_PROVISION_VWL}' => safe($user,'have_additional_provision_vwl') ? $user['have_additional_provision_vwl'] : ''
                    , '{PK_ADDITIONAL_PROVISION_VWL}'      => safe($user,'additional_provision_vwl') ? $user['additional_provision_vwl'] : ''
                    , '{PK_HAVE_SUPPLEMENTARY_PENSION}'    => safe($user,'have_supplementary_pension') ? $user['have_supplementary_pension'] : ''
                    , '{PK_SUPPLEMENTARY_PENSION}'         => safe($user,'supplementary_pension') ? $user['supplementary_pension'] : ''
                    , '{PK_BRUTTO}'                        => safe($user,'brutto') ? $user['brutto'] : ''
                    , '{PK_ADD_COST}'                      => safe($user,'add_cost') ? $user['add_cost'] : ''
                    , '{PK_FULL_COST}'                     => safe($user,'full_cost') ? $user['full_cost'] : ''
                  );
      
      $text[] = $this->doReplace($data[0],$params);
    }
    $text = implode('<br>', $text);
    return $text;
  }  

  private function repeatGoal($data){
    $text = array();
    
    foreach ($this->goals as $key => $goal) {
      if($goal['description'] == ''){
        continue;
      }
      $priorityGoal = '';
      $plainGoal = '';
      
      $requestGoal = Yii::app() -> db -> createCommand()
                             -> select('tbl.*, gl.name goal_name') -> from('spi_request_goal tbl')
                             -> join('spi_goal gl', 'tbl.goal_id = gl.id')
                             -> where('request_school_goal_id = :goal_id ', array(':goal_id' => safe($goal, 'id'))) -> queryAll();

      foreach($requestGoal as $single_goal){
        if($single_goal['value'] == '1'){
          $priorityGoal .= $single_goal['goal_name'].'<br>';
          safe($single_goal,'description') && $single_goal['description'] != '' && $single_goal['description'] != null ? $other_description = $single_goal['description'] : $other_description = '';
        } else if($single_goal['value'] == '2'){
          $plainGoal .= $single_goal['goal_name'].'<br>';
          safe($single_goal,'description') && $single_goal['description'] != '' && $single_goal['description'] != null ? $other_description = $single_goal['description'] : $other_description = '';
        }
      }
      
      $params = array(
            '{FOREACH=GOAL KEY=GD}'           => ''
          , '{FOREACH_END=GOAL}'              => ''
          , '{GD_NAME}'                       => 'Entwicklungziel '.safe($goal,'goal_number')
          , '{GD_DESCRIPTION}'                => safe($goal,'description') ? $goal['description'] : ''

          , '{GD_SCHWERPUNKTZIEL}'            => $priorityGoal
          , '{GD_WEITERESZIEL}'               => $plainGoal
          , '{GD_OTHER}'                      => $other_description

          , '{GD_UMSETZUNG}'                  => safe($goal,'implementation') ? $goal['implementation'] : ''

          , '{GD_INDIKATOREN1}'               => safe($goal,'indicator_1') ? $goal['indicator_1'] : ''
          , '{GD_INDIKATOREN2}'               => safe($goal,'indicator_2') ? $goal['indicator_2'] : ''
          , '{GD_INDIKATOREN3}'               => safe($goal,'indicator_3') ? $goal['indicator_3'] : '' 
          , '{GD_INDIKATOREN4}'               => safe($goal,'indicator_4') ? $goal['indicator_4'] : '' 
          , '{GD_INDIKATOREN5}'               => safe($goal,'indicator_5') ? $goal['indicator_5'] : ''

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