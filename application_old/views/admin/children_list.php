<!-- children_list -->
<div class="row">
    <div class="col-md-12">
        <h2 class="pull-left">Enfants</h2>
        <?php if(_cr('children', 'c')): ?>
        <span class="pull-right"><a class="btn btn-default" href="<?php echo sbase_url() ?>admin/children/add">Ajouter un enfant</a></span>
        <?php endif; ?>
    </div>
</div>

<?php if(!$children): ?>

<div class="row">
    <div class="col-md-12">&nbsp;
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <b>Info</b> : Actuellement aucun enfant ne fut ajouté !
        </div>
    </div>
</div>

<?php else: ?>

<div class="row">
    <div class="col-md-12">
    
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Numéro social</th>
            <th class="hidden-xs hidden-sm">Date naissance</th>
            <th>Parents</th>
            <th>Groupe</th>
            <th></th>
        </thead>
        <tbody>
            <?php  
                foreach ($children as $child):
                    
                    //Calculate age of child
					$date1 = new DateTime( $child->birthdate );
					$date2 = new DateTime( date('Y-m-d') );
					$age = date_diff($date2, $date1);
					$agemois = $age->y*12 + $age->m;
            ?>
                <tr>
                    <td><?php echo $child->firstname ?></td>
                    <td><?php echo $child->lastname ?></td>
                    <td><?php echo $child->socialid ?></td>
                    <td class="hidden-xs hidden-sm"><?php echo $child->birthdate.' ('. ($age->y == 1 ? $age->y.' an': '') . ($age->y > 1 ? $age->y.' ans': '') .' '. ($age->m > 0 ? $age->m.' mois': '').')' ?></td>
                    <td>
                        <?php
                            if(strlen($child->p1_firstname))
                                echo substr($child->p1_firstname,0,1).'. '.$child->p1_lastname;
                            if(strlen($child->p1_firstname) > 0 && strlen($child->p2_firstname) > 0 )
                                echo ' / ';
                            if(strlen($child->p2_firstname))
                                echo substr($child->p2_firstname,0,1).'. '.$child->p2_lastname;
                        ?>
                    </td>
                    <td><?php echo $child->group_name ?></td>
                    <td>
                        <div class="btn-group ">
                            <a type="button" class="btn btn-danger" href="<?php echo sbase_url() ?>admin/children/view/<?php echo $child->id_child ?>"><span class="glyphicon glyphicon-zoom-in"></span></a>
                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo sbase_url() ?>admin/children/viewjournal/<?php echo $child->id_child ?>">Voir journal</a></li>
                                <?php if(_cr('children', 'e')): ?><li><a href="<?php echo sbase_url() ?>admin/children/edit/<?php echo $child->id_child ?>">Editer</a></li><?php endif; ?>
                                <?php if(_cr('children', 'd')): ?><li><a href="<?php echo sbase_url() ?>admin/children/delete/<?php echo $child->id_child ?>" class="btdelete_child"><i class="icon-trash"></i> Supprimer</a></a></li><?php endif; ?>
                            </ul>
                        </div>
                    </td>
                </tr>
            <?php
                endforeach;
            ?>
        </tbody>
    </table>
    </div>
        
    </div>
    
</div>

<!-- Listing footer -->
    <div class="row">
        <div class="col-md-12">
            
        <span class="label label-info">Total : <?php echo $children_count ?></span>
 <?php 
    if(!empty($p) && !empty($children_count) && $children_count > $this->config->item('results_per_page_default')):
        $pages = ceil($children_count / $this->config->item('results_per_page_default'));
?>           
        <!-- pagination -->    
        <ul class="pagination pagination-sm pull-right">
            <?php
                if($p > 1):
            ?>
                <li><a href="<?php echo sbase_url() ?>admin/children/?p=<?php echo $p - 1  ?>&n=<?php echo $this->config->item('results_per_page_default') ?>">&laquo;</a></li>
            <?php
                endif;
            ?>
            <?php
              for ($i = 1; $i <= $pages ; $i++):
            ?>
              <li class="<?php echo (!empty($p) && $p == $i ? 'active' : '') ?>"><a  href="<?php echo sbase_url() ?>admin/children/?p=<?php echo $i ?>&n=<?php echo $this->config->item('results_per_page_default') ?>"><?php echo $i ?></a></li>
            <?php
              endfor;
            ?>
            <?php
                if($p < $pages):
            ?>
                <li><a href="<?php echo sbase_url() ?>admin/children/?p=<?php echo $p + 1  ?>&n=<?php echo $this->config->item('results_per_page_default') ?>">&raquo;</a></li>
            <?php
                endif;
            ?>
        </ul>
        
<?php
    endif;
?>        
        </div>
    </div>
<!-- /Listing footer -->


<?php endif; ?>