<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
  <tr ng-repeat="row in $data">
    <td data-title="'Schul-Nr.'" sortable="'number'">{{row.number}}</td>    
    <td data-title="'Name'" sortable="'name'">{{row.name}}</td>
    <td data-title="'Schultyp'" sortable="'type_name'">{{row.type_name}}</td>
    <td ng-if="page != 'district'" data-title="'Bezirk'" sortable="'district_name'">{{row.district_name}}</td>
    <td data-title="'Adresse'" sortable="'full_address'">{{row.full_address}}</td>
    <td data-title="'Schulleitung'" sortable="'contact_user_name'">{{row.contact_user_name}}</td>
    <td data-title="'Telefon'" sortable="'phone'">{{row.phone}}</td>
    <td data-title="'Ansicht / Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
      <a class="btn center-block edit-btn" ng-click="openEdit(row, !canEdit(row.id))">
        <i class="ion-eye"  ng-if="!canEdit(row.id)"></i>
        <i class="ion-edit" ng-if="canEdit(row.id)"></i>
      </a>
    </td>
    <tr ng-if="!$data.length"><td class="no-result" colspan="8">Keine Items sind verfügbar</td></tr>
  </tr>
</table>
