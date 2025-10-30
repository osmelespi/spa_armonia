$('#modifyAppointmentForm').hide();


$('#openModifyAppointment').on('click', function(e) {
    $('#modifyAppointmentForm').show();
    $('#appointmentForm').hide();
    $(this).addClass('active');
    $('#openAppointment').removeClass('active');
});

$('#openAppointment').on('click', function(e) {
    $('#modifyAppointmentForm').hide();
    $('#appointmentForm').show();
    $(this).addClass('active');
    $('#openModifyAppointment').removeClass('active');
});

