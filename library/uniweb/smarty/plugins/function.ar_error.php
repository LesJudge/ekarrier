<?php

/**
 * ActiveRecord hibaüzenet megjelenítő Smarty függvény.
 * 
 * @param array $params
 * @param Smarty $template
 * @return void
 * 
 * @author Balázs Máté Petró <balazs@uniweb.hu>
 */
function smarty_function_ar_error(array $params, Smarty $template)
{
    $rrParams = array_merge($params, array(
        'template' => $template
    ));
    $rr = new ArErrorRenderer($rrParams);
    echo $rr;
}