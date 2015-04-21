<!-- view:children_ax_dialog_in_out -->
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
        <h4 class="modal-title" id="myModalLabel"><?php echo $child->firstname.' '.$child->lastname ?> - Entrées / Sorties</h4>
      </div>
      <div class="modal-body">
          
        <?php
            if ($error == 1):
        ?>
          <div class="alert alert-danger" role="alert">Oops.. <b><?php echo $child->firstname.' '.$child->lastname ?></b> est déjà présent(e) !
            <?php
                if(!empty($current_checkin->datetime_start) || true):
                    $timein = new Datetime($current_checkin->datetime_start);
            ?>
              <br />Entrée à <b><?php echo date_format($timein,'G:i') ?></b>
            <?php endif; ?>
              
          </div>
        <?php
            endif;
        ?>
          
        <div class="alert alert-danger" role="alert" id="multi-purpose-error" style="display: none">
        </div>
          
          
        <input type="hidden" name="eddate" id="eddate" value="<?php echo date('Y-m-d')?>" >
        <input type="hidden" name="edhour" id="edhour" >
        <input type="hidden" name="edminute" id="edminute" >
        <input type="hidden" name="id" value="<?php echo $child->id_child ?>">
   
    <?php
        // If isCheckedin = false -> Perform checkin
        if (!$isCheckedin && empty($error)):
    ?>
        <script>
            var operationtype = 2;
        </script>
        
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
        // isCheckedin => false
        endif;

        if ($isCheckedin && empty($error)):
          $timein = new Datetime($current_checkin->datetime_start);
    ?>
        <script>
            var operationtype = 3;
        </script>
        
        <input type="hidden" name="edcheckoutdatetime" id="edcheckoutdatetime">

        <div id="checkin">
          <div id="checkin_time" style="width:200px">
            Entrée : <?php echo date_format($timein,'G:i') ?>
          </div>
          <div id="checkout_time" style="width:200px">
            Sortie : <span id="checkouthour">__</span>:<span id="checkoutminute">__</span>
          </div>
        </div>

        <div id="checkout_container" class="clearfix" >

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
        // isCheckedin => true
        endif;
    ?>
        
        
        
        
        
        
      </div>
        <div class="clearfix"><br /></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" id="btclose" style="display:none">Fermer</button>
        <button type="button" class="btn btn-<?php echo ($isCheckedin)? 'danger' : 'success'; ?> btsubmit" id="btsubmitnow" data-now="1">Maintenant</button>
        <button type="button" class="btn btn-primary btsubmit" id="btsubmit">Enregistrer</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


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

    // Checkout
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
    $('.btsubmit').click(function(event){
        event.preventDefault();
        var dnow = 0;
        if($(this).data('now') == 1 )
            dnow = 1;
        if (operationtype == 2)
            ajax_checkin(dnow);
        if (operationtype == 3)
            ajax_checkout(dnow);
    });
    
    $('#btclose').click(function(event){
        location.reload();
    });
  
    // Process checkin
    function ajax_checkin(dnow){
          $('#btsubmit').prevent;
          $('#btsubmitnow').prevent;
          var data = '';
          data = $('#form').serialize()+'&type=2';
          if(dnow == 1)
              data = data+'&usenow=1';
          $.ajax({
              type: 'POST',
              url: base_url+'admin/children/ajaxcheckinout',
              async: true,
              cache: false,
              data: data,
              dataType: "html",
              success: function(data){
                  result = jQuery.parseJSON(data);
                  if(result.error == 0)
                  {
                    $('#multi-purpose-error').html('L\'heure indiquée est incomplète !').show();
                  }
                  else if(result.error == 100)
                  {
                    $('#multi-purpose-error').html('Opération non éxecutée. Cet enfant est actuellement déjà entrée !').show();  
                  }
                  else if(result.error == 101)
                  {
                    $('#multi-purpose-error').html('L\'heure indiquée est en conflit avec un autre temps de présence du jour !').show();  
                  }
                  else
                  {
                    $('.modal-body').html('Opération effectuée avec succés !');
                    $('.btsubmit').hide();
                    $('#btclose').show();
                  }
            }
          });
    }
    
    // Process checkout
    function ajax_checkout(dnow){
          $('#btsubmit').prevent
          var data = '';
          data = $('#form').serialize()+'&type=3';
          if(dnow == 1)
              data = data+'&usenow=1';
          $.ajax({
              type: 'POST',
              url: base_url+'admin/children/ajaxcheckinout',
              async: true,
              cache: false,
              data: data,
              dataType: "html",
              success: function(data){
                  result = jQuery.parseJSON(data);
                  if(result.error == 0)
                  {
                    $('#multi-purpose-error').html('L\'heure indiquée est incomplète !').show();
                  }
                  else if(result.error == 101)
                  {
                    $('#multi-purpose-error').html('L\'heure indiquée est en conflit avec un autre temps de présence du jour !').show();  
                  }
                  else if(result.error == 102)
                  {
                    $('#multi-purpose-error').html('L\'heure de sortie ne peux pas être antérieur à l\'heure d\'entrée !').show();
                  }
                  else
                  {
                    $('.modal-body').html('Opération effectuée avec succés !');
                    $('.btsubmit').hide();
                    $('#btclose').show();
                  }
            }
          });
    }

    
    
    
</script>