<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package   pw_download
 * @author    Marko Cupic, m.cupic@gmx.ch
 * @license   shareware
 * @copyright Marko Cupic 2014
 */


// add content element
$GLOBALS['TL_CTE']['files']['gmk_download'] = 'Markocupic\ContentGmkDownload';

// Set cookie lifetime to 1 month
$GLOBALS['PW_DOWNLOAD']['cookie_lifetime'] = 30*24*60*60;


if (TL_MODE == 'FE')
{
       $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/markocupicgmkdownload/js/gmk_download.js';
       $GLOBALS['TL_CSS'][] = 'bundles/markocupicgmkdownload/css/gmk_download.css|static';
}