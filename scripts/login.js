$('.userType button').click(function() {
    $('button').not(this).removeClass('selectedBtn');
    $(this).addClass('selectedBtn');

    if ($(this).html() == 'Employee') {
    	$('.login-form-emp').addClass('showForm');
    	$('.login-form-patient').removeClass('showForm');
        $('#phn').val('');
    }
    else {
    	$('.login-form-patient').addClass('showForm');
    	$('.login-form-emp').removeClass('showForm');
        $('#empNum').val('');
    }
});
