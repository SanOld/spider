<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
  <tr ng-repeat="row in $data">
    <td data-title="'Nummer'" sortable="'number'">{{row.number}}</td>
    <td data-title="'Name'" sortable="'name'">{{row.name}}</td>
    <td data-title="'Schultyp'" sortable="'type_name'">{{row.type_name}}</td>
    <td ng-if="page != 'district'" data-title="'Bezirk'" sortable="'district_name'">{{row.district_name}}</td>
    <td data-title="'Adresse'" sortable="'address'">{{row.address}}</td>
    <td data-title="'Ansprechpartner(in)'" sortable="'contact_user_name'">{{row.contact_user_name}}</td>
    <td data-title="'Telefon'" sortable="'phone'">{{row.phone}}</td>
    <td data-title="'Ansicht / Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
      <a class="btn pull-left edit-btn" ng-click="openEdit(row, 1)">
        <i class="ion-eye"></i>
      </a>
      <a class="btn pull-right edit-btn" ng-if="canEdit(row.id)" ng-click="openEdit(row)">
        <i class="ion-edit"></i>
      </a>
    </td>
  </tr>
</table>