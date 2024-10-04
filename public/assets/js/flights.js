$(document).ready(function() {
$('#flightOption').change(function() {
if ($(this).val() === 'multi-city') {
$('#multiCityModal').modal('show');
}
});
});