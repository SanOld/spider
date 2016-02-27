<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
  <tr ng-repeat="row in $data">
    <td data-title="'Nummer'" sortable="'number'">{{row.number}}</td>
    <td data-title="'Name'" sortable="'name'">{{row.name}}</td>
    <td data-title="'Schultyp'" sortable="'type_name'">{{row.type_name}}</td>
    <td ng-if="page != 'district'" data-title="'Bezirk'" sortable="'district_name'">{{row.district_name}}</td>
    <td data-title="'Adresse'" sortable="'address'">{{row.address}}</td>
    <td data-title="'Ansprechpartner(in)'" sortable="'contact_user_name'">{{row.contact_user_name}}</td>
    <td data-title="'Telefon'" sortable="'phone'">{{row.phone | tel}}</td>
    <td data-title="'Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
      <a class="btn center-block edit-btn" ng-click="openEdit(row)">
        <i class="ion-edit"></i>
      </a>
    </td>
  </tr>
</table>