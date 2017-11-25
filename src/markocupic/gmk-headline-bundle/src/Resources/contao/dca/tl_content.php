<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 03.12.2016
 * Time: 23:00
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['gmkHeadline'] = '{title_legend},name,type;{double_headline_legend},gmk_headline_one,gmk_headline_two;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';


$GLOBALS['TL_DCA']['tl_content']['fields']['gmk_headline_one'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['gmk_headline_one'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'inputUnit',
    'options'                 => array('span','h1', 'h2', 'h3', 'h4', 'h5', 'h6'),
    'eval'                    => array('maxlength'=>200),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_content']['fields']['gmk_headline_two'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_content']['gmk_headline_two'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'inputUnit',
    'options'                 => array('span','h1', 'h2', 'h3', 'h4', 'h5', 'h6'),
    'eval'                    => array('maxlength'=>200),
    'sql'                     => "varchar(255) NOT NULL default ''"
);