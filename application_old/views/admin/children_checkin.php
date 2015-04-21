<!-- children_checkin -->

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
            <h2><?php echo $child->firstname.' '.$child->lastname ?></h2>Checkin
        </div>
    
    </div>
</div>
    
    <?php if(!isset($success)): ?>
    
<?php 
    $attributes = array('class' => 'form-horizontal', 'id' => 'frm_edit', 'role' => 'form');
    echo form_open_multipart('admin/children/checkin/'.$child->id_child, $attributes);
?>   
<input type="hidden" name="id" value="<?php echo $child->id_child ?>">
<input type="hidden" name="usenow" id="edusenow" value="0">
<input type="hidden" name="pickup" id="edpickup" value="0">

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
        
        
    <div class="time-panel">
            
        <div id="panel-now">
            <div id="time-now">
                <a class="btn btn-lg btn-danger" id="btusenow"><span class="glyphicon glyphicon-remove "></span> Maintenant</a>
                <a class="btn btn-default" id="btshowtimeselector"><span class="glyphicon glyphicon-time" ></span></a>
            </div>
        </div>
        
        <div class="time-selector-container" id="time-selector" style="display:none">
            <div class="row">
                <div class="col-md-6 align-right" >
                    <div>
                        <select class="time-select" name="hour" id="hour" autocomplete="off">
                            <?php
                                $h = (int)date('H');
                                for($i = 6; $i <= 19 ; $i++): ?>
                            <option value="<?php echo $i ?>" <?php echo ($i === $h ? 'selected="selected"':'' ) ?>><?php echo sprintf('%02d', $i) ?> h</option>
                            <?php endfor; ?>
                        </select>

                        <select class="time-select" name="minute" id="minute">
                            <option value="0">00 min</option>
                            <option value="5">05 min</option>
                            <option value="10">10 min</option>
                            <option value="15">15 min</option>
                            <option value="20">20 min</option>
                            <option value="25">25 min</option>
                            <option value="30">30 min</option>
                            <option value="35">35 min</option>
                            <option value="40">40 min</option>
                            <option value="45">45 min</option>
                            <option value="50">50 min</option>
                            <option value="55">55 min</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6 align-left" >
                    <a class="btn btn-lg btn-danger" id="bthidetimeselector"><span class="glyphicon glyphicon-remove" > </span> Fermer</a>
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

<div class="clearfix"><br /></div> 
    
<div class="row">
    <div class="col-md-12">
        
        <div class="pickup-panel">
        
            <div class="pickup-tab">
                <h2>Personnes</h2>
            </div>
        
            <div class="subpanel-header">
                <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;Parents</h4>
            </div>
            <div class="subpanel-content" id="subpanel_parents">
                
            <?php if($parents): ?>
            <?php
                foreach ($parents as $p):
            ?>
                <div class="row data-row">
                    <div class="col-md-1 data-picture">
                        <img src="#" width="70" height="70">
                    </div>
                    <div class="col-md-3 data-right"><h3><?php echo $p->firstname ?></h3>
                        <a class="btn btn-default select_pickup" data-unselectbtn="unselect_pickup_p_<?php echo $p->id_parent ?>" data-val="p_<?php echo $p->id_parent ?>">Séléctionner <span></span></a>
                        &nbsp;
                        <a class="btn btn-danger unselect_pickup" id="unselect_pickup_p_<?php echo $p->id_parent ?>" style="display:none" ><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </div>
                <!--<input type="radio" name="pickup" id="pickup" value="p_<?php echo $p->id_parent ?>"> <?php echo $p->firstname ?>-->
            <?php
                endforeach;
            ?>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">Pas de parents associés</div>
            <?php endif; ?>
            </div>
            
            <div class="subpanel-header">
                <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;Personnes autorisées</h4>
            </div>
            
            <div class="subpanel-content" id="subpanel_trustees">
            <?php if($trustees): ?>
            <?php
                foreach ($trustees as $t):
            ?>
                <div class="row data-row">
                    <div class="col-md-1 data-picture">
                        <img src="#" width="70" height="70">
                    </div>
                    <div class="col-md-3 data-right"><h3><?php echo $t->name ?></h3>
                        <a class="btn btn-default select_pickup" data-unselectbtn="unselect_pickup_t_<?php echo $t->id_child_trustee ?>" data-val="t_<?php echo $t->id_child_trustee ?>">Séléctionner <span></span></a>
                        &nbsp;
                        <a class="btn btn-danger unselect_pickup" id="unselect_pickup_t_<?php echo $t->id_child_trustee ?>" style="display:none" ><span class="glyphicon glyphicon-remove"></span></a>
                    </div>
                </div>
                <!--<input type="radio" name="pickup" id="pickup" value="p_<?php echo $t->id_child_trustee ?>"> <?php echo $t->name ?>-->
            <?php
                endforeach;
            ?>
            <?php else: ?>
                <div class="alert alert-warning" role="alert">Pas de personnes autorisées</div>
            <?php endif; ?>
            </div>
            
        </div>
        
        
    </div>
</div>
   
<div class="clearfix"><br /></div> 

<div class="row">
    <div class="col-md-12">
        
        
        
        <div class="documents-panel">
            <div class="documents-tab">
                <h2>Documents</h2>
            </div>
            
            <div class="subpanel-content">
                <?php if($documents): ?>
                <?php
                    foreach ($documents as $d):
                ?>
                    <div class="row data-row">
                        <div class="col-md-1 data-picture">
                            <img src="#" width="70" height="70">
                        </div>
                        <div class="col-md-3 data-right"><h3><?php echo $d->docname ?></h3>
                            <?php echo $d->description ?>
                        </div>
                    </div>
                <?php
                    endforeach;
                ?>
                <?php else: ?>
                    <div class="alert alert-warning" role="alert">Pas de documents</div>
                <?php endif; ?>
            </div> 
            
        </div>
        
        
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