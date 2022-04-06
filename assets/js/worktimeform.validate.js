$("form[name='timeForm']").validate({

rules: {
    start_time: {
        required: true
    },
    end_time: {
        required: true
    }

},
// Specify validation error messages
messages: {
    start_time: "Bitte auf start drucken",
    end_time: "Bitte gib deinen Lastname ein.",
    email: {
        required: "Bitte gib deinen Name ein",
        minlength: "Bitte  gib ein valid email ein"
    }


},
submitHandler: function (timeForm) {
    var formData = {
        'start_time': $('#txtstart_time').val(),
        'end_time':$('#txtend_time').val()

    };
    console.log(formData);
    // POST data to the php file
    $.ajax({
        url: '/save',
        data: formData,
        type: 'POST',
        success: function (formData) {
            // For Notification

            var $alertDiv = $(".mailResponse");
            $alertDiv.show();
            $alertDiv.find('.alert').removeClass('alert-danger alert-success');
            $alertDiv.find('.mailResponseText').text("Vielen Dank für Ihre Nachricht. Ich kontaktiere dich so schnell wie Möglich");

            if (formData.error) {
                $alertDiv.find('.alert').addClass('alert-danger');
                $alertDiv.find('.mailResponseText').text(formData.messageNotice);
            } else {
                $alertDiv.find('.alert').addClass('alert-success');
                $alertDiv.find('.mailResponseText').text(formData.messageNotice);
                document.getElementById("contactForm").reset();
                setTimeout(function(){
                    window.location.reload(1);
                }, 500);
            }
        }
    });
}

});


