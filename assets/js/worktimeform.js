$("#timeForm").submit(function(e){

    e.preventDefault();
    var start = $('#txtstart_time').val();
    var formData = {
            'start_time': start,
            'end_time':$('#txtend_time').val(),
            'user_id': $('#user_id').val(),
            'worktime_id': $('#worktime_id').val()
        };
    console.log(formData);
        $.ajax({
        type: "POST",
        url: "/savedata",
        data: formData,
        success: function(data){
            if (!start) {
                alert('StartTime required')
            }else{
                $("#message").text("Vielen Dank");
            }
            $("#txtstart_time").val('');
            $('#txtend_time').val('');

        }
    });
});
