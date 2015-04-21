<?php  if ( ! defined('BASEPATH')) exit('No direct script  access allowed');

/*
 * Helper for functionalities related and needed by MY_Controller
 * 
 */


/*
* Automatically uses https if set in config file
*/

function sbase_url($uri = '')
{
    $CI =& get_instance();
    $url = $CI->config->base_url($uri);
    if($CI->config->item('use_https') && $CI->https)
        $url = str_ireplace('http://', 'https://', $url);
    return $url;
}

/*
 * Show the generic child picture based on gender
 */
function genderPicture_deprecated($gender = 1)
{
    if($gender == 1)
        $url = 'assets/img/kid_picture_boy_black.png';
    else
        $url = 'assets/img/kid_picture_girl_black.png';
    return $url;
}

/*
 * Output the JS source files into the html document's head
 */

function output_js()
{
    $CI =& get_instance();
    foreach ($CI->_js as $key => $value)
    {
        echo '<script src="'.$value.'"></script>'.PHP_EOL;
    }           
}


/*
 * Output the CSS source files into the html document's head
 */

function output_css()
{
    $CI =& get_instance();
    foreach ($CI->_css as $key => $value)
    {
        echo '<link href="'.$value.'" rel="stylesheet" media="all">'.PHP_EOL;
    }           
}



