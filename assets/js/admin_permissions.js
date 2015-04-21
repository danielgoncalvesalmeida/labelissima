/*
 * Administration - Profiles
 * 
 */

// Begin of document ready
$(document).ready(function(){
    
    // For flash notices
    $('#flash_success').delay(7000).fadeOut(600);
    $('#flash_error').delay(7000).fadeOut(600);
    
    // Confirm deletion
    $(".btdelete_profile").click(function(event){
        if(confirm('Etes-vous sûre de vouloir supprimer le profile ?')){
           return true;  
        } else {
           event.preventDefault(); 
        }
    });
    
    var id = $("#id").val();
    if(!id > 0) id = 0;
    
    // Check name
    $("#iName").change(function(){
        $('#cgName').removeClass('has-error');
        $('#cgName .msg-required').hide()
        $.ajax({
                type: 'POST',
                url: base_url+'admin/profiles/ajax',
                async: true,
                cache: false,
                dataType: 'json', 
                data : csrf_token_name+'='+csrf_token_hash+'&type=1&name='+$(this).val()+'&exclude='+id,
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
    
    // Check prior submit
    $("#submitProfileAdd").click(function(event){
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
    
    // Check prior submit
    $("#submitProfileSave").click(function(event){
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