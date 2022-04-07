$("#start_time").click(function(){
    event.preventDefault();
    $("#txtstart_time").val(now())
});

$("#end_time").click(function(){
    event.preventDefault();
    $("#txtend_time").val(now())
});

const now = () =>{
    var now = new Date();
    var d = now.getDate();
    var m =  now.getMonth();
    m += 1;
    var y = now.getFullYear();
    var h = now.getHours();
    var min = now.getMinutes();
    var sec = now.getSeconds();
    return y + "-" + m + "-" + d +" "+ h + ":"+min+":"+sec
}




