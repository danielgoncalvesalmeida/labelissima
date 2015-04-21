<!-- view:children_modal_selectparent -->

<!-- Modal -->
<div class="modal fade" id="modalwindow" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Séléctionnez un parent</h4>
      </div>
      <div class="modal-body">
          
        <div style="overflow: auto; height:250px">
          <input type="hidden" value="<?php echo $position ?>" name="parent_position" id="parent_position">

        <?php
            foreach ($parents as $parent):
          ?>
            <div style="clear: both;line-height: 35px" class="select_parent">
                <?php echo trim($parent->lastname.' '.$parent->firstname).(!empty($parent->socialid) ? ' ['.$parent->socialid.']' : '') ?>
                <span style="float:right;padding: 8px 10px"><button class="btn btn-default btn-xs" data-idparent="<?php echo $parent->id_parent ?>" data-parentname="<?php echo trim($parent->lastname.' '.$parent->firstname) ?>">Séléctionner</span>
            </div>
          <?php
            endforeach;
          ?>
        </div>
        
 
      </div>
        <div class="clearfix"><br /></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="btclose">Fermer</button>
        <!-- <button type="button" class="btn btn-primary" id="btsubmit">Enregistrer</button> -->
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<script>
	$('#modalwindow').modal();
    
    // Begin of document ready
    $(document).ready(function(){
       
       $(".select_parent button").click(function(event){
           var position = $("#parent_position").val();
           var idselectedparent = $(this).data("idparent");
           var parentname = $(this).data("parentname");
        $("#edparent"+position).val(idselectedparent);
        $("#iParent"+position+"_display").val(parentname);
    });
       
    });
    
    // Save
    $('#btsubmit').click(function(event){
        event.preventDefault();
        ajax_addevent();
    });
    
    /*
    $('#btclose').click(function(event){
        location.reload();
    });
    */
    
    // Select the event type
    $('.icons_event_type').click(function (){
        console.log($(this).data('id_type'));
        $('#id_type').val($(this).data('id_type'));
        $('.icons_event_type').removeClass('selected');
        $(this).addClass('selected');
    });
  
    // Process checkin
    function ajax_addevent(){
          $.ajax({
              type: 'POST',
              url: base_url+'admin/children/ajaxevent',
              async: true,
              cache: false,
              data: $('#form').serialize()+'&type=2',
              dataType: 'json',
              success: function(data){
                if(data === true){
                    $('.modal-body').html('Opération effectuée avec succés !');
                }else{
                    $('.modal-body').html('Une erreur est survenue !');
                }
                  $('#btsubmit').hide();
                  $('#btclose').show();
            }
          });
    }
    
  
</script>