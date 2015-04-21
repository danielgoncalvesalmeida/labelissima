<h2>This is a test</h2>

<?php
    $i = 0;
    $perrow = 3;
    $cnt = count($groups);
    $n = 0;
    foreach ($groups as $value):
        if($i == 0)
            echo '*<br>';
        
        echo $value ;
        
        $i++;
        $n++;
        if(($i % $perrow) == 0 || $n == $cnt)
        {
            $i = 0;
            echo '<br>!';
        }
         
    endforeach;
?>
  