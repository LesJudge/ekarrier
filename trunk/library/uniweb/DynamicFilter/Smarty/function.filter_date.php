<?php

function smarty_function_filter_date(array $params, \Smarty $template)
{
    if (isset($params['filterTemplateId']) && isset($params['filterKey']) && isset($params['filterLabel'])) {
        $smarty = new \Smarty;
        $smarty->assign('filterTemplateId', $params['filterTemplateId']);
        $smarty->assign('filterKey', $params['filterKey']);
        $smarty->assign('filterLabel', $params['filterLabel']);
        echo $smarty->fetch('library/uniweb/DynamicFilter/Smarty/View/Date.tpl');
    } else {
        trigger_error('Hibás paraméterek!', E_USER_ERROR);
    }
}