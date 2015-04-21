/*
 * Administration - Groups
 * 
 */

// Begin of document ready
$(document).ready(function(){
    
    // For flash notices
    $('#flash_success').delay(7000).fadeOut(600);
    
    // Confirm deletion
    $(".btdelete_group").click(function(event){
        if(confirm('Etes-vous sûre de vouloir supprimer le group ?')){
           return true;  
        } else {
           event.preventDefault(); 
        }
    });
    
    // Check name
    $("#iName").change(function(){
        $('#cgName').removeClass('has-error');
        $('#cgName .msg-required').hide()
        $.ajax({
                type: 'POST',
                url: base_url+'admin/groups/ajax',
                async: true,
                cache: false,
                dataType: 'json', 
                data : csrf_token_name+'='+csrf_token_hash+'&type=1&name='+$(this).val(),
                success: function(data)
                { 
                    if(data === true){
                        $('#cgName').addClass('has-error');
                        $('#cgName .msg-exists').show();
                    } else {
                        $('#cgName').removeClass('has-error');
                        $('#cgName .msg-exists').hide();
                    }

                }
        });
    });
    
    $("#submitGroupAdd").click(function(event){
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