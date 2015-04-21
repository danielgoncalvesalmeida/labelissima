/*
 * Administration - Groups
 * 
 */

// Begin of document ready
$(document).ready(function(){
    
    // For flash notices
    $('#flash_success').delay(7000).fadeOut(600);
    
    // Confirm deletion
    $(".btdelete_parent").click(function(event){
        if(confirm('Etes-vous sûre de vouloir supprimer?')){
           return true;  
        } else {
           event.preventDefault(); 
        }
    });
    
    // Check social id
    $("#iSocialid").change(function(){
        $('#cgSocialid').removeClass('has-error');
        $('#cgSocialid .help-block').hide();
        
        if($('#iSocialid').val() == ''){
            $('#cgSocialid').addClass('has-error');
            $('#cgSocialid .msg-required').show();
            errorCount++;
        } else {
            $('#cgSocialid').removeClass('has-error');
            $('#cgSocialid .msg-required').hide();
        }
        
        var id = $("#id").val();
        if(!id > 0) id = 0;
        
        $.ajax({
                type: 'POST',
                url: base_url+'admin/parents/ajax',
                async: true,
                cache: false,
                dataType: 'json', 
                data : csrf_token_name+'='+csrf_token_hash+'&type=1&value='+$(this).val()+'&exclude='+id,
                success: function(data)
                { 
                    if(data === true){
                        $('#cgSocialid').addClass('has-error');
                        $('#cgSocialid .msg-exists').show();
                    } else {
                        $('#cgSocialid').removeClass('has-error');
                        $('#cgSocialid .msg-exists').hide();
                    }

                }
        });
    });
    
    
    // Check email
    $("#iEmail").change(function(){
        $('#cgEmail').removeClass('has-error');
        $('#cgEmail .help-block').hide();
        
        /* only if field is requiered
        if($('#iEmail').val() == ''){
            $('#cgEmail').addClass('has-error');
            $('#cgEmail .msg-required').show();
            errorCount++;
        } else {
            $('#cgEmail').removeClass('has-error');
            $('#cgEmail .msg-required').hide();
        }
        */
        
        if($('#iEmail').val() != ''){
            $.ajax({
                    type: 'POST',
                    url: base_url+'admin/parents/ajax',
                    async: true,
                    cache: false,
                    dataType: 'json', 
                    data : csrf_token_name+'='+csrf_token_hash+'&type=2&value='+$(this).val(),
                    success: function(data)
                    { 
                        if(data === true){
                            $('#cgEmail').addClass('has-error');
                            $('#cgEmail .msg-exists').show();
                        } else {
                            $('#cgEmail').removeClass('has-error');
                            $('#cgEmail .msg-exists').hide();
                        }

                    }
            });
        }
    });
    
    
    $("#submitAdd").click(function(event){
        var errorCount = 0;
        
        if($('#iName').val() == ''){
            $('#cgName').addClass('has-error');
            $('#cgName .msg-required').show();
            errorCount++;
        } else {
            $('#cgName').removeClass('has-error');
            $('#cgName .msg-required').hide();
        }
        
        if(errorCount > 0){
            event.preventDefault();
        }
        
    });
    
}); // End of document ready