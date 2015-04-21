/*
 * Administration - Login
 * 
 */

// Begin of document ready
$(document).ready(function(){
    
    // Init the hidden field
    $('input[name="edpwd"]').val('');
    
    $("li").click(function(){
        var p;
        var k;
        
        $(this).addClass("bttouched").delay(100).queue(function(next){
            $(this).removeClass("bttouched");
            next();
        });
        
        p = $('input[name="edpwd"]').val();
        k = $(this).data("key");
        
        // Delete key
        if(k == 'del'){
            $('input[name="edpwd"]').val('');
            $("#pwd_caption").html('&nbsp;');
            return true;
        }

        $('input[name="edpwd"]').val(p+k);
        
        p = $('input[name="edpwd"]').val();
        k = '';
        for(var i=0;i<p.length;i++){
            //k = k+"*";
            k = k+'<img src="'+base_url+'assets/img/login-dot.png">&nbsp;';
        }
        $("#pwd_caption").html(k);
    });
        
}); // End of document ready