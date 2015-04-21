/*
 * Administration - Children/addevent
 * 
 */

// Begin of document ready
$(document).ready(function(){
    
    $(".event_selectors li").click(function(event){
        var id_event_type = $(this).data("id_child_event_type");
        
        $(".event_selectors li img").removeClass("selected");
        $("#id_child_event_type_"+id_event_type+" img").addClass("selected");
        $("#id_child_event_type").val(id_event_type);
    });

    $(".event_smileys_icons ul li").click(function(event){
        var id_smiley = $(this).data("id_smiley");

        $(".event_smileys_icons ul li").removeClass("selected");
        $("#li_smiley_"+id_smiley).addClass("selected");
        $("#id_smiley").val(id_smiley);
    });
    
    
}); // End of document ready
