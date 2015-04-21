<!-- groups_add -->

        
        
<?php if(isset($flash_success)): ?>    
        
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success">
                <?php echo $flash_success ?>
            </div>
        
            <div class="form-group">
                <div class="controls">
                    <a class="btn btn-default" href="<?php echo (empty($link_back) ? sbase_url().'admin/groups/' : sbase_url().$link_back ) ?>">OK</a>
                    
                    <?php if(isset($id_group)): ?><a class="btn btn-default" href="<?php echo sbase_url().'admin/groups/edit/'.$id_group ?>">Editer</a><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
        
<?php else: ?>
        
    <div class="row">
        <div class="col-md-12">
            <a href="<?php echo (empty($link_back) ? sbase_url().'admin/groups/' : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Retour</a>
            <h3>Ajouter un group</h3>
            <br />
        </div>
    </div>

        <?php 
            $attributes = array('class' => 'form-horizontal', 'id' => 'frm_add', 'role' => 'form');
            echo form_open('admin/groups/add',$attributes);
        ?>
        
    <div class="form-group <?php echo (strlen(form_error('edname')) > 0 ? 'has-error' : '' ) ?>" id="cgName">
        <label class="col-sm-2 control-label" for="iName">Nom du group</label>
        <div class="col-sm-4">
            <input class="form-control" type="text" name="edname" id="iName" placeholder="nom du group" value="<?php echo set_value('edname'); ?>">
            <span class="help-block msg-required" style="display:none" >Champ obligatoire</span>
            <span class="help-block msg-exists" style="display:none" >Info : Ce nom existe déjà</span>
            <?php if(strlen(form_error('edname')) > 0): ?>
                <span class="help-block"><?php echo form_error('edname') ?></span>
            <?php endif; ?>
        </div>
    </div>



    <div class="form-group <?php echo (strlen(form_error('edsite')) > 0 ? 'has-error' : '' ) ?>" >
        <label class="col-sm-2 control-label" for="iSite">Site</label>
        <div class="col-sm-4">
            <?php 
                $options = array();
                foreach ($sites as $site) {
                    $options[$site->id_site] = $site->name;
                }
                echo form_dropdown('edsite', $options, null, 'class="form-control"');
            ?>
            <span class="help-block msg-validation-error" ><?php echo form_error('edsite') ?></span>
        </div>
    </div>
       
    <div class="form-group">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4">
            <label class="radio-inline" >
                <input type="radio" name="edenabled" id="iEnabled" value="1" <?php echo set_radio('edenabled', '1', true); ?> > Actif
            </label>
            <label class="radio-inline" >
                <input type="radio" name="edenabled" id="iDisabled" value="0" <?php echo set_radio('edenabled', '0', true); ?> > Désactivé
            </label>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-12 col-sm-offset-2 col-sm-4">
            <button type="submit" class="btn btn-primary" name="submitGroupAdd" id="submitGroupAdd">Enregistrer</button>
            &nbsp;&nbsp;
            <a class="btn btn-danger" href="<?php echo (empty($link_back) ? sbase_url().'admin/groups/' : sbase_url().$link_back ) ?>">Annuler</a>
        </div>
    </div>
            
       
    </form>
        
<?php endif ?>
