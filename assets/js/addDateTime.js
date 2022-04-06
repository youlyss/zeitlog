$("#start_time").click(function(){
    event.preventDefault();
    let now     = new Date();
    $("#txtstart_time").val(now.toString())
});

$("#end_time").click(function(){
    event.preventDefault();
    let now     = new Date();
    $("#txtend_time").val(now.toString())
});




