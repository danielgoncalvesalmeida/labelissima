/*
 * Administration - Desktop
 * 
 */

// Begin of document ready
$(document).ready(function(){
    
    // For flash notices
    $('#flash_success').delay(7000).fadeOut(600);
    
    $('#bt_filter_noshow').click(function(){
        $('.container_status').hide();
        $('#container_noshow').show();
    });
    
    $('#bt_filter_in').click(function(){
        $('.container_status').hide();
        $('#container_in').show();
    });
    
    $('#bt_filter_out').click(function(){
        $('.container_status').hide();
        $('#container_out').show();
    });
    
    $('#bt_all').click(function(){
        $('.container_status').hide();
        $('#container_all').show();
    });
    
});

// Goto link
function goto(url)
{
    document.location = url;
}


// Load the modal form for checkins
function checkin(id)
{
    $.ajax({
        type: 'POST',
        url: base_url+'admin/children/ajaxcheckinout',
        async: true,
        cache: false,
        data: csrf_token_name+'='+csrf_token_hash+'&type=1&checkin=1&id='+id,
        dataType: 'html',
        success: function(data){
            $('#modaldialogs').html(data);	
        }
    });
}

// Load the modal form for checkins
function checkout(id)
{
    $.ajax({
        type: 'POST',
        url: base_url+'admin/children/ajaxcheckinout',
        async: true,
        cache: false,
        data: csrf_token_name+'='+csrf_token_hash+'&type=1&checkout=1&id='+id,
        dataType: 'html',
        success: function(data){
            $('#modaldialogs').html(data);	
        }
    });
}

// Load the modal for add event
function eventdialog(id)
{
    $.ajax({
        type: 'POST',
        url: base_url+'admin/children/ajaxevent',
        async: true,
        cache: false,
        data: csrf_token_name+'='+csrf_token_hash+'&type=1&id='+id,
        dataType: 'html',
        success: function(data){
            $('#modaldialogs').html(data);	
        }
    });
}