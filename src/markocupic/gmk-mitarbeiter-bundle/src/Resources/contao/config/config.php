<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @package   FondspolicenVergleich
 * @author    Marko Cupic
 * @license   SHAREWARE
 * @copyright Marko Cupic 2016
 */







/**
 * BACK END MODULES
 *
 * Back end modules are stored in a global array called "BE_MOD". You can add
 * your own modules by adding them to the array.
 */
$GLOBALS['BE_MOD']['content']['mitarbeiter'] = array(
        'tables' => array('tl_gmk_mitarbeiter'),
        'icon'   => 'bundles/markocupicgmkmitarbeiter/icon.png'
);


/**
 * Content Elements
 */
$GLOBALS['TL_CTE']['gmk_mitarbeiter'] = array(
        'gmkMitarbeiterList' => 'Markocupic\Gmk\GmkMitarbeiterList',
        'gmkMitarbeiterIntroducing' => 'Markocupic\Gmk\GmkMitarbeiterIntroducing',
);

