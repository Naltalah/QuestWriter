$('#saveConfig').on("click",function(e) {
    e.preventDefault();
    $.post('src/ajax/saveconfig.ajax.php',$('#config_form').serialize(),function(data) {
        $('#saveConfig').attr("display","disabled");
        $('#saveConfig').fadeOut(0);
        $('#config').html(data).hide();
        $('#config').fadeIn(500);
    });
});
$('#saveTextConfig').on("click",function(e){
    e.preventDefault();
    $.post('src/ajax/savetextconfig.ajax.php',$('#config_form').serialize(),function(data){
        $('#saveTextConfig').attr("display","disabled");
        $('#saveTextConfig').fadeOut(0);
        $('#config').html(data).hide();
        $('#config').fadeIn(500)
    });
});
$('#saveGlobalConfig').on("click",function(e){
    e.preventDefault();
    $.post('src/ajax/saveglobalconfig.ajax.php',$('#globalConfig').serialize(),function(data){
        $('#saveGlobalConfig').attr("display","disabled");
        $('#saveGlobalConfig').fadeOut(0);
        $('#config').html(data).hide();
        $('#config').fadeIn(500)
    });
});
$('#generateQuest').on('click',function(e){
    e.preventDefault();
    var send = true;
    // Check Required
    $(':input[required]',$('#gen_form')).each(function(idx,elem) {
        if ($(elem).val() == '') {
            $(elem).css("background-color","salmon");
            send = false;
            return;
        }
    });

    // Send
    if (send == true) {
        $.post('src/ajax/generatequest.ajax.php',$('#gen_form').serialize(),function(data){
            $('#output').html(data).hide();
            $('#output').fadeIn(500);
        });
    } else {
        $('#output').html("<div class='alert'>You need to fill out all required fields!</div>").hide();
        $('#output').fadeIn(250);
    }
});
$(':input').on('focus',function() {
    if (!this.hasAttribute("readonly"))
        $(this).css("background-color","white");
});