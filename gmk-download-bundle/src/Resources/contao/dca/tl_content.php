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


// add palette
$GLOBALS['TL_DCA']['tl_content']['palettes']['gmk_download'] = '{type_legend},type,headline;{source_legend},singleSRC;{dnl_config_legend},linkTitle,titleText;{modal_config_legend},gmkDownloadModalTitle;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

// add field
$GLOBALS['TL_DCA']['tl_content']['fields']['gmkDownloadModalTitle'] = array(
    'label'         => &$GLOBALS['TL_LANG']['tl_content']['gmkDownloadModalTitle'],
    'exclude'       => false,
    'inputType'     => 'text',
    'eval'          => array('mandatory' => true, 'maxlength' => 255, 'allowHtml' => false),
    'sql'           => 'text NULL'
);
