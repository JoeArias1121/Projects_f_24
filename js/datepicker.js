$(document).ready(function() {
  $("#datepicker").datepicker({
    showButtonPanel: true
  });
  $('#agenda').click(function() {
    $("#datepicker").focus();
  });
});

