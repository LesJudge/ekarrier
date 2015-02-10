<?php
/**
 * Renderel egy LIKE dinamikus szűrőt.
 * 
 * @param array $params Paramétereket tartalmazó tömb.
 * @param Smarty $template Template objektum.
 * @return string
 */
function smarty_function_dynamic_filter_text_like(array $params, Smarty $template)
{
    foreach ($params as $key => $value) {
        $template->assign($key, $value);
    }
    return $template->fetch(__DIR__ . '/../views/dynamic_filter_text_like_view.tpl');
}