<!-- parents_view -->

<?php if(isset($flash_success)): ?>
    <div class="row">
        <div class="col-md-12">
                <div class="alert alert-success" id="flash_success">
                    <?php echo $flash_success ?>
                </div>   
        </div>
    </div>
<?php endif; ?>     

    <div class="row">
        <div class="col-md-12 profile-view">
            <?php if(_cr('parents', 'e')): ?><a href="<?php echo (empty($link_back) ? sbase_url().'admin/parents/edit/'.$parent->id_parent : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Editer</a><?php endif; ?>
            <a href="<?php echo (empty($link_back) ? sbase_url().'admin/parents/' : sbase_url().$link_back ) ?>" class="btn btn-default pull-right">Retour</a>
            <div class="main-header">
                <h2>Parent</h2>Vue profile
            </div>
        </div>
    </div>
 

<div class="profile-view">
    <div class="profile-page">

    <div class="row">
        <div class="col-md-3">
            <div class="profile-info-left">
                <h3><?php echo $parent->lastname.' '.$parent->firstname ?></h3>
            </div>
            
        </div>
        <div class="col-md-9">
            <div class="profile-info-right">
                <div class="info-section">
                    <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;Informations</h4>
                </div>
                
                
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Numéro social</div>
                    <div class="col-xs-3 data-value"><?php echo $parent->socialid ?></div>
                </div>
                
                <div class="info-section">
                    <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;Contact</h4>
                </div>
                
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Email</div>
                    <div class="col-xs-3 data-value"><?php echo $parent->email ?></div>
                </div>
                
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Tél. mobile</div>
                    <div class="col-xs-3 data-value"><?php echo $parent->mobile ?></div>
                </div>
                
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Tél. du domicile</div>
                    <div class="col-xs-3 data-value"><?php echo $parent->phone_home ?></div>
                </div>
                
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Tél. au travail</div>
                    <div class="col-xs-3 data-value"><?php echo $parent->phone_work ?></div>
                </div>
                
                <div class="info-section">
                    <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;Adresse</h4>
                </div>
                
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Adresse</div>
                    <div class="col-xs-3 data-value"><?php echo $parent->address ?></div>
                </div>
                
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Localité</div>
                    <div class="col-xs-3 data-value"><?php echo $parent->city ?></div>
                </div>
                
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Code postal</div>
                    <div class="col-xs-3 data-value"><?php echo $parent->code ?></div>
                </div>

                <div class="row data-row">
                    <div class="col-xs-3 data-name">Pays</div>
                    <div class="col-xs-3 data-value"><?php echo $parent->country_iso ?></div>
                </div>
                
                <div class="info-section">
                    <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;Détails</h4>
                </div>
                
                <div class="row data-row">
                    <div class="col-xs-3 data-name">Langues parlées</div>
                    <div class="col-xs-3 data-value"><?php echo $parent->language ?></div>
                </div>
                
                <div class="info-section">
                    <h4><span class="glyphicon glyphicon-stop"></span>&nbsp;Enfants</h4>
                </div>
                
                
                <?php
                    if(!$active_children):
                ?>
                    <div class="row">
                        <div class="col-sm-6"><div class="alert alert-warning" role="alert">Aucun enfant assigné ou actif</div></div>
                    </div>
                <?php 
                    else:
                        foreach ($active_children as $c):
                ?>
                
                    <div class="row data-row">
                        <div class="col-xs-3 data-name"><img src="<?php echo sbase_url() ?>admin/img/child/<?php echo $c->id_child ?>/profilepicture.jpg" class="img-thumbnail" width="80" heigth="80"></div>
                        <div class="col-xs-8 data-value"><?php echo $c->firstname ?>
                            <br />
                            <?php
                            //Calculate age of child
                                $date1 = new DateTime( $c->birthdate );
                                $date2 = new DateTime( date('Y-m-d') );
                                $age = date_diff($date2, $date1);
                                $agemois = $age->y*12 + $age->m;
                                echo $c->birthdate.' ('. ($age->y == 1 ? $age->y.' an': '') . ($age->y > 1 ? $age->y.' ans': '') .' '. ($age->m > 0 ? $age->m.' mois': '').')';
                            ?>

                        </div>
                    </div> 
                
                <?php
                        endforeach;
                    endif;
                ?>
                
            </div>
        </div>
    </div>
        
    </div>
</div>
            
    
    

   
    

