<!-- view:children_ax_dialog_addevent -->
<?php
  $frmaction = sbase_url().'admin/children/';
  $attributes = array('class' => 'form-horizontal', 'method'=>'post', 'id'=>'form');
  echo form_open($frmaction,$attributes);
?>


<!-- Modal -->
<div class="modal fade" id="modalcheckinout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $child->firstname.' '.$child->lastname ?> - Notice</h4>
      </div>
      <div class="modal-body">
          
         <input type="hidden" name="id" value="<?php echo $child->id_child ?>"> 
          
          
         
         <textarea class="form-control" rows="5" name="description"></textarea>
          
        <?php
            if(!empty($event_types)):
        ?>
         <div class="event_type_icons">
             <input type="hidden" name="id_type" value="" id="id_type">
             <ul class="events_list">
                <?php
                   foreach ($event_types as $event):
                ?>        
                    <li ><img class="icons_event_type" data-id_type="<?php echo $event->id_child_event_type ?>" src="<?php echo sbase_url() ?>assets/img/icons/<?php echo $event->icon ?>" title="<?php echo $event->name ?>"></li>
                <?php
                    endforeach;
                ?>
             </ul>
         </div>
        <?php
            endif;
        ?>
         <div class="event_smileys_icons">
            <input type="hidden" name="id_smiley" value="0" id="id_smiley">
            <ul class="events_list">
            <?php
                foreach ($emoticons as $ek => $e):
             ?>        
                 <li id="li_smiley_<?php echo $ek ?>"><img class="icons_event_smiley" data-id_smiley="<?php echo $ek ?>" src="<?php echo sbase_url() ?>assets/img/icons/<?php echo $e ?>" ></li>
             <?php
                 endforeach;
             ?>
            </ul>
         </div>
 
      </div>
        <div class="clearfix"><br /></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="btclose" style="display:none">Fermer</button>
        <button type="button" class="btn btn-primary" id="btsubmit">Enregistrer</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php echo form_close() ?>


<script>
	$('#modalcheckinout').modal();
    
    // Save
    $('#btsubmit').click(function(event){
        event.preventDefault();
        ajax_addevent();
    });
    
    $('#btclose').click(function(event){
        location.reload();
    });
    
    // Select the event type
    $('.icons_event_type').click(function (){
        console.log($(this).data('id_type'));
        $('#id_type').val($(this).data('id_type'));
        $('.icons_event_type').removeClass('selected');
        $(this).addClass('selected');
    });
    
    // Select the smiley
    $('.icons_event_smiley').click(function (){
        console.log($(this).data('id_smiley'));
        $('#id_smiley').val($(this).data('id_smiley'));
        $('.event_smileys_icons li').removeClass('selected');
        $('#li_smiley_'+$(this).data('id_smiley')).addClass('selected');
    });
  
    // Save the event
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