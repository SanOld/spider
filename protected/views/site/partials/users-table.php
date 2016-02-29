<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
  <tr ng-repeat="row in $data" ng-class="{'disable': row.is_active == '0'}">
    <td data-title="'Name'" sortable="'name'" ng-bind="::row.name"></td>
    <td ng-if="['district', 'school'].indexOf(page) === -1" data-title="'Benutzer-Typ'" sortable="'type_name'" ng-bind="::row.type_name"></td>
    <td ng-if="['performer', 'district', 'school'].indexOf(page) === -1" data-title="'Organisation'" sortable="'relation_name'" ng-bind="::row.relation_name"></td>
    <td data-title="'Benutzername'" sortable="'login'"><a href="#" ng-bind="::row.login"></a></td>
    <td data-title="'Email'" sortable="'email'"><a href="mailto:{{row.email}}" ng-bind="::row.email"></a></td>
    <td data-title="'Telefon'" sortable="'phone'" ng-bind="::row.phone | tel"></td>
    <td data-title="'Status'" sortable="'status_name'" ng-bind="::row.status_name"></td>
    <td data-title="'Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
      <a class="btn center-block edit-btn" ng-click="openEdit(row)">
        <i class="ion-edit"></i>
      </a>
    </td>
  </tr>
</table>
<div class="notice">
  <span class="color-notice"></span>
  Deaktivierte Benutzer
</div>