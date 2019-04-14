$(window).on('load', function(){
    
    
    
    $('#messagemodal').modal('show');
    
    $('#logonid').modal('show');
    
    $('#logonbut').on('click', function(){
        var strdata = $("#logonform").serialize();
        
        $.post('ajax.php?login',strdata,function(content){
            var data = JSON.parse(content);
            if( data['success'] == true ){
                document.location = '/admin/index.php';
            } else {
                alert(data['content']);
            }
        });
    });
    
});

function pay(){
    $("#paymentform").submit();
}