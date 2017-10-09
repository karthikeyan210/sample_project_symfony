$(document).ready(function() {
    var today = new Date();
    var currentYear = today.getFullYear();
    $( ".js-datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '1980:'+currentYear,
    });
});