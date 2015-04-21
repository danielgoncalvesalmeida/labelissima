/*
 * Administration - Children/Checkin
 * 
 */

// Begin of document ready
$(document).ready(function(){
    
    $("#btusenow").click(function(event){
        var usenow = $("#edusenow").val();
        
        if(usenow == 0)
        {
            $(this).removeClass("btn-danger").addClass("btn-success");
            $("#btusenow span").removeClass("glyphicon-remove").addClass("glyphicon-ok");
            $("#edusenow").val(1);
        }
        if(usenow == 1)
        {
            $(this).removeClass("btn-success").addClass("btn-danger");
            $("#btusenow span").removeClass("glyphicon-ok").addClass("glyphicon-remove");
            $("#edusenow").val(0);
        }
        event.preventDefault();
    });
    
    $("#btshowtimeselector").click(function(event){

        $("#edusenow").val(0);
        $("#time-selector").show();
        $("#panel-now").hide();
        event.preventDefault();
    });
    
    $("#bthidetimeselector").click(function(event){

        $("#edusenow").val(1);
        $("#btusenow").removeClass("btn-danger").addClass("btn-success");
        $("#btusenow span").removeClass("glyphicon-remove").addClass("glyphicon-ok");
        
        $("#time-selector").hide();
        $("#panel-now").show();
        event.preventDefault();
    });
    
    $(".select_pickup").click(function(event){
        var valpickup = $(this).data("val");
        $("#edpickup").val(valpickup);
        
        
        
        // Unset all the others
        $(".unselect_pickup").hide();
        $(".select_pickup").attr("data-isselected", "0");
        $(".select_pickup").removeClass("btn-success").addClass("btn-default");
        $(".select_pickup span").removeClass("glyphicon").removeClass("glyphicon-ok");
      
        var unselectbtn = $(this).data("unselectbtn");
        $("#"+unselectbtn).show();
        
        // Set this
        $(this).attr("data-isselected", "1");
        $(this).addClass("btn-success");
        $(this).children("span").addClass("glyphicon").addClass("glyphicon-ok");

        event.preventDefault();
    });
    
    $(".unselect_pickup").click(function(event){
        $("#edpickup").val(0);
        
        // Unset all the others
        $(".select_pickup").attr("data-isselected", "0");
        $(".select_pickup").removeClass("btn-success").addClass("btn-default");
        $(".select_pickup span").removeClass("glyphicon").removeClass("glyphicon-ok");
      
        // Set this
        $(this).hide();

        event.preventDefault();
    });
    
    
    
}); // End of document ready
