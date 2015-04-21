<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar_model extends CI_Model {
    
    private $week_days_names = array(
                '1' => 'lundi',
                '2' => 'mardi', 
                '3' => 'mercredi',
                '4' => 'jeudi',
                '5' => 'vendredi',
                '6' => 'samedi',
                '7' => 'dimanche'
            );
    
    function __construct()
	{
		parent::__construct();
        
	}

    /*
     * Returns an array with the week days names
     */
	public function getArrayWeekDaysNames()
	{
        return array(
            '1' => 'lundi',
            '2' => 'mardi', 
            '3' => 'mercredi',
            '4' => 'jeudi',
            '5' => 'vendredi',
            '6' => 'samedi',
            '7' => 'dimanche'
        );
    }
    
    public function getWeekDaysBasedNavigation($viewdate = null, $daysperweek = 7)
    {
        if(empty($viewdate))
            $viewdate = new Datetime(date('Y-m-d'));
        else
            $viewdate = new Datetime($viewdate);
        
        $viewdate_str = date_format($viewdate, 'Y-m-d');
        
        $dayofweek = date_format($viewdate,'N');
        if($dayofweek > 1)
        { 
            $monday = $viewdate;
            $monday->sub(new DateInterval('P'.($dayofweek-1).'D'));
        }
        else
            $monday = $viewdate;
        // Some bug fix -> for an unknown reason it is better to use a date string and 
        // create a new Datetime object in the for loop
        $monday_str = date_format($monday, 'Y-m-d');
        
        $_t = new DateTime($monday_str);
        $_t->sub(new DateInterval('P1W'));
        
        $viewdate = new DateTime($viewdate_str);
        $nav[] = array(
            'backward' => true,
            'label' => 'Semaine précédente', 
            'date' => date_format($_t, 'Y-m-d'), 
            'current' => false,
            'd' => date_format($_t, 'j'),
            'm' => date_format($_t, 'n'),
            'y' => date_format($_t, 'Y'),
        );
        $nav[] = array(
            'label' => 'lundi', 
            'date' => date_format($monday, 'Y-m-d'), 
            'current' => (date_format($monday, 'Y-m-d') === date_format($viewdate, 'Y-m-d')? true : false),
            'd' => date_format($monday, 'j'),
            'm' => date_format($monday, 'n'),
            'y' => date_format($monday, 'Y'),
        );
        
        for ($index = 1; $index < $daysperweek; $index++) 
        {
            $tmp = new DateTime($monday_str);
            $tmp->add(new DateInterval('P'.$index.'D'));
            $nav[] = array(
                'label' => $this->week_days_names[$index+1], 
                'date' => date_format($tmp, 'Y-m-d'), 
                'current' => (date_format($tmp, 'Y-m-d') === date_format($viewdate, 'Y-m-d')? true : false),
                'd' => date_format($tmp, 'j'),
                'm' => date_format($tmp, 'n'),
                'y' => date_format($tmp, 'Y'),
            );
        }
        
        $_t = new DateTime($monday_str);
        $_t->add(new DateInterval('P1W'));
        
        $nav[] = array(
            'forward' => true,
            'label' => 'Semaine suivante',
            'date' => date_format($_t, 'Y-m-d'), 
            'current' => false,
            'd' => date_format($_t, 'j'),
            'm' => date_format($_t, 'n'),
            'y' => date_format($_t, 'Y'),
        );
        
        // $nav[] = array('label' => 'Aujourd\'hui', 'date' => date('Y-m-d'), 'current' => true);
     
        return $nav;
    }
}

/* End of file login_model.php */