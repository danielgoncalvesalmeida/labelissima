<!-- children_addevent -->

<?php if(!$child): ?>

<div class="row">
    <div class="col-md-12">&nbsp;
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-danger">
            <b>Erreur</b> : Veuillez sélectionner un enfant !
        </div>
    </div>
</div>

<?php else: ?>

<div class="checkin-dialog">
    
<div class="row">
    <div class="col-md-12">
        
        <div class="main-header">
            <h2><?php echo $child->firstname.' '.$child->lastname ?></h2>Notice
        </div>
    
    </div>
</div>
    
<?php if(!isset($success)): ?>
    
<?php 
    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_edit', 'role' => 'form');
    echo form_open_multipart('admin/children/addevent/'.$child->id_child, $attributes);
?>   
<input type="hidden" name="id" value="<?php echo $child->id_child ?>">

<div class="row">
    <div class="col-md-12">
        
        <?php if(isset($errors)): ?>
            <br />
            <div class="alert alert-danger" role="alert"><strong>Oops.. une erreur s'est produite !</strong><br />
                <?php foreach ($errors as $e): ?>
                    <?php echo $e ?><br />
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        
    <div class="event-panel">
        <br />
        <div class="row">
            <div class="col-md-9">
                <div class="event_type_icons">
                    <input type="hidden" id="id_child_event_type" name="id_child_event_type" value="0" >
                    <ul class="event_selectors" >
                    <?php
                        foreach ($event_types as $event):
                     ?>        
                         <li id="id_child_event_type_<?php echo $event->id_child_event_type ?>" data-id_child_event_type="<?php echo $event->id_child_event_type ?>"><img class="icons_event_smiley" src="<?php echo sbase_url() ?>assets/img/icons/<?php echo $event->icon ?>" title="<?php echo $event->name ?>" ></li>
                     <?php
                         endforeach;
                     ?>
                    </ul>
                 </div>
            </div>
        </div>
        <br />
        
        <div class="row">
            <div class="col-md-9">
                <textarea placeholder="Écrivez une notice si nécessaire" cols="80" rows="5" name="memo"></textarea>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-9">
                <div class="event_smileys_icons">
                    <input type="hidden" name="id_smiley" value="0" id="id_smiley">
                    <ul>
                    <?php
                        foreach ($emoticons as $ek => $e):
                     ?>        
                         <li id="li_smiley_<?php echo $ek ?>" data-id_smiley="<?php echo $ek ?>"><img class="icons_event_smiley"  src="<?php echo sbase_url() ?>assets/img/icons/<?php echo $e ?>" ></li>
                     <?php
                         endforeach;
                     ?>
                    </ul>
                 </div>
            </div>
        </div>
        
        
    </div>
    
    </div>
</div>

<div class="clearfix"><br /></div> 

<div class="row">
    <div class="col-md-12 " style="text-align: center">
        <input type="submit" name="save" class="btn btn-lg btn-primary" value="Enregistrer">
    </div>
</div>


    
</form>
<?php
    // if !isset($success)
    elseif(isset($success)):
?>
    Bravo !

<?php endif; ?>



<?php endif; ?>