$(document).ready(function() {
  setInterval(function() {
    var $dataTableRoot = $('.dataTable[data-report="OpeniAppTracker.trackByApp"]');
    var dataTableInstance = $dataTableRoot.data('uiControlObject');
    dataTableInstance.resetAllFilters();
    dataTableInstance.reloadAjaxDataTable();
  }, 10 * 1000);
});