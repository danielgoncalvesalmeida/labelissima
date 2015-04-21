/*
 * Administration - Children
 * 
 */

// Begin of document ready
$(document).ready(function(){
    
    // For flash notices
    $('#flash_success').delay(7000).fadeOut(600);
    $('#flash_error').delay(14000).fadeOut(600);
    
    // Confirm deletion
    $(".btdelete_child").click(function(event){
        if(confirm('Etes-vous sûre de vouloir supprimer?')){
           return true;  
        } else {
           event.preventDefault(); 
        }
    });
    
    // Check social id
    $("#iSocialid").change(function(){
        var errorCount = 0;
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
                url: base_url+'admin/children/ajax',
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
    
    
    // Check birth date
    $("#iBirthdate").change(function(){
        var errorCount = 0;
        $('#cgBirthdate').removeClass('error');
        $('#cgBirthdate .help-block').hide();
        
        if($('#iBirthdate').val() == ''){
            $('#cgBirthdate').addClass('has-error');
            $('#cgBirthdate .msg-required').show();
            errorCount++;
        } else {
            $('#cgBirthdate').removeClass('has-error');
            $('#cgBirthdate .msg-required').hide();
        }
        
        $.ajax({
                type: 'POST',
                url: base_url+'admin/children/ajax',
                async: true,
                cache: false,
                dataType: 'json', 
                data : csrf_token_name+'='+csrf_token_hash+'&type=2&value='+$(this).val(),
                success: function(data)
                { 
                    if(data === false){
                        $('#cgBirthdate').addClass('has-error');
                        $('#cgBirthdate .msg-invalid').show();
                    } else {
                        $('#cgBirthdate').removeClass('has-error');
                        $('#cgBirthdate .msg-invalid').hide();
                    }
                }
        });
    });
    
    $(".btshowpanel").click(function(event){
        target = $(this).data('target');
        hide = $(this).data('hide');
        $('#'+target).show();
        
        $('#'+hide).hide();
        event.preventDefault();
    });
    
    
    // Confirm and delete the profile picture
    $("#btdeleteprofilepicture").click(function(event){
        if(confirm('Etes-vous sûre de vouloir supprimer l\'image?')){
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: base_url+'admin/children/ajax',
                async: true,
                cache: false,
                dataType: 'json', 
                data : csrf_token_name+'='+csrf_token_hash+'&type=3&value='+$(this).data('id'),
                success: function(data)
                { 
                    if(data === true){
                        $('#div_profilepicture').hide();
                    } 
                }
            });
        } else {
           event.preventDefault(); 
        }
    });
    
    
    // Confirm and delete the trustee profile picture
    $("#btdeletetrusteeprofilepicture").click(function(event){
        if(confirm('Etes-vous sûre de vouloir supprimer l\'image?')){
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: base_url+'admin/children/ajax',
                async: true,
                cache: false,
                dataType: 'json', 
                data : csrf_token_name+'='+csrf_token_hash+'&type=4&value='+$(this).data('id'),
                success: function(data)
                { 
                    if(data === true){
                        $('#div_profilepicture').hide();
                    } 
                }
            });
        } else {
           event.preventDefault(); 
        }
    });
    
    
    // Remove parent 1
    $("#btdelparent1").click(function(event){
        $("#edparent1").val('0');
        $("#iParent1").val('');
        $("#iParent1").prop('disabled', false);
        event.preventDefault();
        $(this).hide();
    });
    
    // Remove parent 2
    $("#btdelparent2").click(function(event){
        $("#edparent2").val('0');
        $("#iParent2").val('');
        $("#iParent2").prop('disabled', false);
        event.preventDefault();
        $(this).hide();
    });
    
    // Select parent1
    $("#btaddparent1").click(function(event){
        $.ajax({
            type: 'POST',
            url: base_url+'admin/children/ajaxselectparent',
            async: true,
            cache: false,
            data: csrf_token_name+'='+csrf_token_hash+'&position=1',
            dataType: 'html',
            success: function(data){
                $('#modaldialogs').html(data);	
            }
        });
        event.preventDefault();
    });
    
    // Select parent2
    $("#btaddparent2").click(function(event){
        $.ajax({
            type: 'POST',
            url: base_url+'admin/children/ajaxselectparent',
            async: true,
            cache: false,
            data: csrf_token_name+'='+csrf_token_hash+'&position=2',
            dataType: 'html',
            success: function(data){
                $('#modaldialogs').html(data);	
            }
        });
        event.preventDefault();
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
    
    // For edit form
    $("#nav_tab_child").click(function(event){
        $("#nav_tab li").removeClass('active');
        $(this).addClass('active');
        
        $(".tab_content").hide();
        $("#tab_child").show();
    });
    
    $("#nav_tab_info").click(function(event){
        $("#nav_tab li").removeClass('active');
        $(this).addClass('active');
        
        $(".tab_content").hide();
        $("#tab_info").show();
    });
    
    $("#nav_tab_authorisations").click(function(event){
        $("#nav_tab li").removeClass('active');
        $(this).addClass('active');
        
        $(".tab_content").hide();
        $("#tab_authorisations").show();
    });
    
    $("#nav_tab_emergency").click(function(event){
        $("#nav_tab li").removeClass('active');
        $(this).addClass('active');
        
        $(".tab_content").hide();
        $("#tab_emergency").show();
    });
    
    $("#nav_tab_documents").click(function(event){
        $("#nav_tab li").removeClass('active');
        $(this).addClass('active');
        
        $(".tab_content").hide();
        $("#tab_documents").show();
    });
    
    // For view page
    $("#view_nav_tab_child").click(function(event){
        $("#nav_tab li").removeClass('active');
        $(this).addClass('active');
        
        $(".tab_content").hide();
        $("#tab_child").show();
    });
    
    $("#view_nav_tab_info").click(function(event){
        $("#nav_tab li").removeClass('active');
        $(this).addClass('active');
        
        $(".tab_content").hide();
        $("#tab_info").show();
    });
    
    $("#view_nav_tab_authorisations").click(function(event){
        $("#nav_tab li").removeClass('active');
        $(this).addClass('active');
        
        $(".tab_content").hide();
        $("#tab_authorisations").show();
    });
    
    $("#view_nav_tab_emergency").click(function(event){
        $("#nav_tab li").removeClass('active');
        $(this).addClass('active');
        
        $(".tab_content").hide();
        $("#tab_emergency").show();
    });
    
    $("#view_nav_tab_trustees").click(function(event){
        $("#nav_tab li").removeClass('active');
        $(this).addClass('active');
        
        $(".tab_content").hide();
        $("#tab_trustees").show();
    });
    
    $("#view_nav_tab_documents").click(function(event){
        $("#nav_tab li").removeClass('active');
        $(this).addClass('active');
        
        $(".tab_content").hide();
        $("#tab_documents").show();
    });
    
    // Confirm deletion 
    $(".btdelete_trustee").click(function(event){
        if(confirm('Etes-vous sûre de vouloir supprimer?')){
           return true;  
        } else {
           event.preventDefault(); 
        }
    });
    
    $("#submitAddTrustee").click(function(event){
        var errorCount = 0;
        
        if($('#iTrustname').val() == ''){
            $('#cgTrustname').addClass('has-error');
            $('#cgTrustname .msg-required').show();
            errorCount++;
        } else {
            $('#cgTrustname').removeClass('has-error');
            $('#cgTrustname .msg-required').hide();
        }
        
        if(errorCount > 0){
            event.preventDefault();
        }
        
    });
    
    // Confirm deletion 
    $(".btdelete_document").click(function(event){
        if(confirm('Etes-vous sûre de vouloir supprimer?')){
           return true;  
        } else {
           event.preventDefault(); 
        }
    });
    
    $("#submitAddDocument").click(function(event){
        var errorCount = 0;
        
        if($('#iDocname').val() == ''){
            $('#cgDocname').addClass('has-error');
            $('#cgDocname .msg-required').show();
            errorCount++;
        } else {
            $('#cgDocname').removeClass('has-error');
            $('#cgDocname .msg-required').hide();
        }
        
        if($('#iDocfile').val() == ''){
            $('#cgDocfile').addClass('has-error');
            $('#cgDocfile .msg-required').show();
            errorCount++;
        } else {
            $('#cgDocfile').removeClass('has-error');
            $('#cgDocfile .msg-required').hide();
        }
        
        if(errorCount > 0){
            event.preventDefault();
        }
        
    });
    
}); // End of document ready

// Load the modal for add event
function selectParentDialog(position)
{
    $.ajax({
        type: 'POST',
        url: base_url+'admin/children/ajaxevent',
        async: true,
        cache: false,
        data: csrf_token_name+'='+csrf_token_hash+'&position='+position,
        dataType: 'html',
        success: function(data){
            $('#modaldialogs').html(data);	
        }
    });
}