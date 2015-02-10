<?php
$config['APP_PATH'] = 'modelgeneralo';
$config['APP_LINK'] = array(
    '' => 'modelgeneralo',
    'edit' => 'modelgeneralo'
);
// True or False tömb.
$config['TRUE_OR_FALSE'] = array(0 => 'Nem', 1 => 'Igen');
// Mezők lehetséges típusait tartalmazó tömb.
$config['FIELDTYPES'] = array(
    'text' => 'Text input',
    'textarea' => 'Textarea',
    'select' => 'Select',
    'checkbox' => 'Checkbox',
);
// Mezők lehetséges típusait tartalmazó tömb.
$config['TYPES'] = array(
    'VARCHAR' => 'VARCHAR',
    'TINYINT' => 'TINYINT',
    'INT' => 'INT',
    'TEXT' => 'TEXT',
    'DATE' => 'DATE',
    'TIME' => 'TIME',
    'DATETIME' => 'DATETIME',
);
// Típusok prefixeit tartalmazó tömb.
$config['TYPE_PREFIXES'] = array(
    'text' => 'Txt',
    'textarea' => 'Txt',
    'select' => 'Sel',
    'checkbox' => 'Chk',
);
// Validációs szabályokat tartalmazó tömb.
$config['VALIDATION_RULES'] = array(
    'text' => 'string',
    'textarea' => 'string',
    'select' => 'select',
    'checkbox' => 'required',
);
// Scriptek behívásáért felelős kódokat tartalmazó tömb.
$config['SCRIPTS'] = array(
    'tinymce' => '<script type="text/javascript" src="../js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>'."\n".'<script type="text/javascript" src="../js/admin/add_tinymce.js"></script>',
    'sheepit' => '<script type="text/javascript" src="../js/jquery.sheepItPlugin.js"></script>',
    'prettyphoto' => '<script type="text/javascript" src="../js/jquery.prettyPhoto.js"></script>',
);
?>