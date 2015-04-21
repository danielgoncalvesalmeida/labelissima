<!-- view:children_ax_dialog_in_out -->
<?php
  $frmaction = sbase_url().'admin/children/checkin/';
  $attributes = array('class'=>'form-horizontal','method'=>'post','id'=>'form');
  echo form_open($frmaction,$attributes);
?>
	
<div class="modal fade" id="modalcheckinout" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel"><?php echo $child->firstname.' '.$child->lastname ?> - Entrées / Sorties</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="eddate" id="eddate" value="<?php echo date('Y-m-d')?>" >
        <input type="hidden" name="edhour" id="edhour" >
        <input type="hidden" name="edminute" id="edminute" >
        <input type="hidden" name="id" value="<?php echo $child->id_child ?>">
        
    <?php
        // If status = false -> No checkin yet for today -> Perform checkin
        if (!$status):
      ?>
            <input type="hidden" name="edcheckindatetime" id="edcheckindatetime">

            <div id="checkin">
            <ul>
              <li class="in_hour_bt" id="6">6h</li>
              <li class="in_hour_bt" id="7">7h</li>
              <li class="in_hour_bt" id="8">8h</li>
              <li class="in_hour_bt" id="9">9h</li>
              <li class="in_hour_bt" id="10">10h</li>
              <li class="in_hour_bt" id="11">11h</li>
              <li class="in_hour_bt" id="12">12h</li>
              <li class="in_hour_bt" id="13">13h</li>
              <li class="in_hour_bt" id="14">14h</li>
              <li class="in_hour_bt" id="15">15h</li>
              <li class="in_hour_bt" id="16">16H</li>
              <li class="in_hour_bt" id="17">17h</li>
              <li class="in_hour_bt" id="18">18h</li>
              <li class="in_hour_bt" id="19">19h</li>
              <li class="in_hour_bt" id="20">20h</li>
            </ul>

          </div>

          <div id="checkin_time">
            <span id="checkinhour"></span>:<span id="checkinminute"></span>
          </div>

          <div id="checkin_minutes_keypad">
            <ul>
              <li class="in_minutes_bt" id="00">00</li>
              <li class="in_minutes_bt" id="05">05</li>
              <li class="in_minutes_bt" id="10">10</li>
              <li class="in_minutes_bt" id="15">15</li>
              <li class="in_minutes_bt" id="20">20</li>
              <li class="in_minutes_bt" id="25">25</li>
              <li class="in_minutes_bt" id="30">30</li>
              <li class="in_minutes_bt" id="35">35</li>
              <li class="in_minutes_bt" id="40">40</li>
              <li class="in_minutes_bt" id="45">45</li>
              <li class="in_minutes_bt" id="50">50</li>
              <li class="in_minutes_bt" id="55">55</li>
            </ul>
          </div>


      <?php
        //Status False
        endif;

        if ($status == 1):
          $timein = new Datetime($checkins[0]['datetime']);
      ?>
        <input type="hidden" name="edcheckoutdatetime" id="edcheckoutdatetime">

        <div id="checkin">
          <div id="checkin_time" style="width:200px">
            Entrée : <?php echo date_format($timein,'G:i') ?>
          </div>
          <div id="checkout_time" style="width:200px">
            Sortie : <span id="checkouthour">__</span>:<span id="checkoutminute">__</span>
          </div>
        </div>

        <div id="checkout_container" class="clearfix" style="margin-top:60px" >

          <div id="checkout">
            <ul>
              <li class="out_hour_bt" id="6">6h</li>
              <li class="out_hour_bt" id="7">7h</li>
              <li class="out_hour_bt" id="8">8h</li>
              <li class="out_hour_bt" id="9">9h</li>
              <li class="out_hour_bt" id="10">10h</li>
              <li class="out_hour_bt" id="11">11h</li>
              <li class="out_hour_bt" id="12">12h</li>
              <li class="out_hour_bt" id="13">13h</li>
              <li class="out_hour_bt" id="14">14h</li>
              <li class="out_hour_bt" id="15">15h</li>
              <li class="out_hour_bt" id="16">16H</li>
              <li class="out_hour_bt" id="17">17h</li>
              <li class="out_hour_bt" id="18">18h</li>
              <li class="out_hour_bt" id="19">19h</li>
              <li class="out_hour_bt" id="20">20h</li>
            </ul>

          </div>



          <div id="checkout_minutes_keypad">
            <ul>
              <li class="out_minutes_bt" id="00">00</li>
              <li class="out_minutes_bt" id="05">05</li>
              <li class="out_minutes_bt" id="10">10</li>
              <li class="out_minutes_bt" id="15">15</li>
              <li class="out_minutes_bt" id="20">20</li>
              <li class="out_minutes_bt" id="25">25</li>
              <li class="out_minutes_bt" id="30">30</li>
              <li class="out_minutes_bt" id="35">35</li>
              <li class="out_minutes_bt" id="40">40</li>
              <li class="out_minutes_bt" id="45">45</li>
              <li class="out_minutes_bt" id="50">50</li>
              <li class="out_minutes_bt" id="55">55</li>
            </ul>

          </div>
        </div>

      <?php
        // Status == 1 
        endif;
      ?>
        
        
        
        
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="btclose" style="display:none">Close</button>
        <button type="button" class="btn btn-primary" id="btsubmit">Enregistrer</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  
</div>
    
<?php echo form_close() ?>

<script>
	$('#modalcheckinout').modal();

  // Checkin
  $('.in_hour_bt').click(function (){
    $('.in_hour_bt').removeClass('checkin_selected');
    $(this).addClass('checkin_selected');
    $('#checkinhour').html($(this).attr('id'));
    $('#edhour').val($(this).attr('id'));
    $('#edcheckindatetime').val( $('#eddate').val()+' '+$('#edhour').val()+':'+$('#edminute').val() );
  });

  $('.in_minutes_bt').click(function (){
    $('.in_minutes_bt').removeClass('checkin_selected');
    $(this).addClass('checkin_selected');
    $('#checkinminute').html($(this).attr('id'));
    $('#edminute').val($(this).attr('id'));
    $('#edcheckindatetime').val( $('#eddate').val()+' '+$('#edhour').val()+':'+$('#edminute').val() );
  });

  //Checkout
  $('.out_hour_bt').click(function (){
    $('.out_hour_bt').removeClass('checkout_selected');
    $(this).addClass('checkout_selected');
    $('#checkouthour').html($(this).attr('id'));
    $('#edhour').val($(this).attr('id'));
    $('#edcheckoutdatetime').val( $('#eddate').val()+' '+$('#edhour').val()+':'+$('#edminute').val() );
  });

  $('.out_minutes_bt').click(function (){
    $('.out_minutes_bt').removeClass('checkout_selected');
    $(this).addClass('checkout_selected');
    $('#checkoutminute').html($(this).attr('id'));
    $('#edminute').val($(this).attr('id'));
    $('#edcheckoutdatetime').val( $('#eddate').val()+' '+$('#edhour').val()+':'+$('#edminute').val() );
  });

  // Save
  $('#btsubmit').click(function(event){
        event.preventDefault();  
        ajax_check_isvaliddate();
  });
  
  function ajax_check_isvaliddate(){
        $('#btsubmit').prevent
        $.ajax({
            type: 'POST',
            url: base_url+'admin/children/ajaxcheckin',
            async: true,
            cache: false,
            data: $('#form').serialize()+'&type=2',
            dataType: "html",
            success: function(data){
                $('.modal-body').html('Opération effectuée avec succés !');
                $('#btsubmit').hide();
                $('#btclose').show();
                $('#bt_check_<?php echo $child->id_child ?>').removeClass('btn-success');
                $('#bt_check_<?php echo $child->id_child ?>').addClass('btn-danger');
                $('#bt_check_<?php echo $child->id_child ?>').html('Check-out');
          }
        });
}


</script>

<!-- /view:children_ax_dialog_in_out -->