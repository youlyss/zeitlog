$("#timeForm").submit(function(e){
    e.preventDefault();
        var formData = {
            'start_time': $('#txtstart_time').val(),
            'end_time':$('#txtend_time').val(),
            'user_id': $('#user_id').val(),
            'worktime_id': $('#worktime_id').val()
        };
        $.ajax({
        type: "POST",
        url: "/savedata",
        data: formData,
        success: function(data){
            $("#message").text("Vielen Dank");
            $("#txtstart_time").val('');
            $('#txtend_time').val('');

        }
    });
});
