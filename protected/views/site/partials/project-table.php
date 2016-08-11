<table id="datatable" ng-cloak ng-table="tableParams" class="table dataTable table-hover table-bordered table-edit">
  <tr ng-repeat="row in $data" ng-class="row.status+'-row'">
    <td header="'headerCheckbox.html'">
      <label class="cr-styled">
        <input type="checkbox" ng-model="checkboxes.items[row.id]">
        <i class="fa"></i>
      </label>
    </td>
    <td data-title="'Kennziffer'" sortable="'code'">{{row.code}}</td>
    <td data-title="'Schule'" sortable="'school_name'">
      <a href="/schools#id={{school.id}}" ng-repeat="school in row.schools" class="school-td" target="_blank">{{school.name}}</a>
    </td>
    <td data-title="'Träger'" sortable="'performer_name'"><a href="/performers#id={{row.performer_id}}" target="_blank">{{row.performer_name}}</a></td>
    <td data-title="'Bezirk'" sortable="'district_name'"><a href="/districts#id={{row.district_id}}" target="_blank">{{row.district_name}}</a></td>
    <td data-title="'Ansicht / Bearbeiten'" header-class="'dt-edit'" class="dt-edit">
      <a class="btn center-block edit-btn" ng-click="openEdit(row, !canEdit()) || row.is_old != 0">
        <i class="ion-eye"  ng-if="!canEdit() || row.is_old != 0"></i>
        <i class="ion-edit" ng-if="canEdit() && row.is_old == 0"></i>
      </a>
    </td>
    <tr ng-if="!$data.length"><td class="no-result" colspan="5">Keine Ergebnisse</td></tr>
  </tr>
  </table>
<!-- <div class="notice">
  <span class="color-notice"></span>
  Deaktivierte Benutzer
</div> -->