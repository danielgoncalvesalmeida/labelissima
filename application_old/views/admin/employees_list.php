<!-- employees_list -->
<div class="row">
    <div class="col-md-12">
        <h2 class="pull-left">Employées</h2>
        <span class="pull-right"><a class="btn btn-default" href="<?php echo sbase_url() ?>admin/employees/add">Ajouter un employée</a></span>
    </div>
</div>

<?php if(!$employees): ?>

<div class="row">
    <div class="col-md-12">&nbsp;
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            <b>Info</b> : Actuellement aucun employée ne fut ajouté !
        </div>
    </div>
</div>

<?php else: ?>

<div class="row">
    <div class="col-md-12">
    
    <div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Numéro social</th>
            <th>Date naissance</th>
            <th>Site par défaut</th>
            <th>Nom d'utilisateur</th>
            <th>Profile utilisateur</th>
            <th>Numéro employée</th>
            <th>Email</th>
            <th></th>
        </thead>
        <tbody>
            <?php  
                foreach ($employees as $employee):
                    
                    //Calculate age of child
					$date1 = new DateTime( $employee->birthdate );
					$date2 = new DateTime( date('Y-m-d') );
					$age = date_diff($date2, $date1);
					$agemois = $age->y*12 + $age->m;
            ?>
                <tr>
                    <td><?php echo $employee->lastname ?></td>
                    <td><?php echo $employee->firstname ?></td>
                    <td><?php echo $employee->socialid ?></td>
                    <td><?php echo $employee->birthdate.' ('. ($age->y == 1 ? $age->y.' an': '') . ($age->y > 1 ? $age->y.' ans': '') .' '. ($age->m > 0 ? $age->m.' mois': '').')' ?></td>
                    <td><?php echo $employee->default_site_name ?></td>
                    <td><?php echo $employee->username ?></td>
                    <td><?php echo $employee->right_profile_name ?></td>
                    <td><?php echo $employee->employee_number ?></td>
                    <td><?php echo $employee->email ?></td>
                    <td>
                        <div class="btn-group ">
                            <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                                <span class="glyphicon glyphicon-edit"></span>&nbsp;&nbsp;<span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                <li><a href="<?php echo sbase_url() ?>admin/employees/edit/<?php echo $employee->id_user ?>">Editer</a></li>
                                <li><a href="<?php echo sbase_url() ?>admin/employees/delete/<?php echo $employee->id_user ?>" class="btdelete_employee"><i class="icon-trash"></i> Supprimer</a></a></li>
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
            
        <span class="label label-info">Total : <?php echo $employees_count ?></span>
<?php 
    if(!empty($p) && !empty($employees_count) && $employees_count > $this->config->item('results_per_page_default')):
        $pages = ceil($employees_count / $this->config->item('results_per_page_default'));
?>            
        <!-- pagination -->    
        <ul class="pagination pagination-sm pull-right">
            <?php
                if($p > 1):
            ?>
                <li><a href="<?php echo sbase_url() ?>admin/employees/?p=<?php echo $p - 1  ?>&n=<?php echo $this->config->item('results_per_page_default') ?>">&laquo;</a></li>
            <?php
                endif;
            ?>
            <?php
              for ($i = 1; $i <= $pages ; $i++):
            ?>
              <li class="<?php echo (!empty($p) && $p == $i ? 'active' : '') ?>"><a  href="<?php echo sbase_url() ?>admin/employees/?p=<?php echo $i ?>&n=<?php echo $this->config->item('results_per_page_default') ?>"><?php echo $i ?></a></li>
            <?php
              endfor;
            ?>
            <?php
                if($p < $pages):
            ?>
                <li><a href="<?php echo sbase_url() ?>admin/employees/?p=<?php echo $p + 1  ?>&n=<?php echo $this->config->item('results_per_page_default') ?>">&raquo;</a></li>
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