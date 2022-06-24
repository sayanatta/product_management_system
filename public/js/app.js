/*** PRINT VALIDATION MESSAGES ***/
function printErrorMsg(msg) {
    $.each(msg, function (key, value) {
        $('#' + key + '_err').text(value);
    });
}

/*** HIDE VALIDATION ERROR MESSAGES ***/
function hide_error_msg(key) {
    $('#' + key + '_err').text('');
}

/*** NUMBER KEY WORDS START ***/
function validate(evt) {
    var theEvent = evt || window.event;

    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
        // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}

/*** DELETE START ***/
function getDeleteRoute($route) {
    document.getElementById('confirm_del').setAttribute("action", $route);
}

/*** TOOLTIP ***/
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
});
