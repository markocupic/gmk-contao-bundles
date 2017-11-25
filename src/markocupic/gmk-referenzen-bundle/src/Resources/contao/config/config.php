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
$GLOBALS['BE_MOD']['content']['referenzen'] = array(
    'tables' => array('tl_gmk_referenzen'),
    'icon' => 'bundles/markocupicgmkreferenzen/images/catalog16.png',
);


/**
 * Content Elements
 */
$GLOBALS['TL_CTE']['gmk_referenzen'] = array(
    'gmkReferenzenList' => 'Markocupic\Gmk\GmkReferenzenList',
    'gmkReferenzenListInfiniteScroll' => 'Markocupic\Gmk\GmkReferenzenListInfiniteScroll',
);


if (TL_MODE == 'FE' && !\Environment::get('isAjaxRequest'))
{

    $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/markocupicgmkreferenzen/js/referenzen_infinite_scroll.js';

}
