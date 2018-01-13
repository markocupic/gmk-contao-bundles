<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 04.12.2016
 * Time: 20:01
 */


// Onload callback
//$GLOBALS['TL_DCA']['tl_content']['config'] ['onload_callback'][] = array('tl_content_gmk_mitarbeiter', 'setPalette');

// Palette
$GLOBALS['TL_DCA']['tl_content']['palettes']['gmkReferenzenList'] = '{type_legend},type;{mitarbeiter_legend};{config_legend},numberOfItems,perPage,skipFirst;{template_legend:hide},referenzenListTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['gmkReferenzenListInfiniteScroll'] = '{type_legend},type;{mitarbeiter_legend};{config_legend},numberOfItems,perPage,skipFirst;{template_legend:hide},referenzenListInfiniteScrollTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';


$GLOBALS['TL_DCA']['tl_content']['fields']['skipFirst'] = array
(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['skipFirst'],
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => array('rgxp' => 'natural', 'tl_class' => 'w50'),
    'sql'       => "smallint(5) unsigned NOT NULL default '0'",
);


$GLOBALS['TL_DCA']['tl_content']['fields']['referenzenListTpl'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_content']['referenzenListTpl'],
    'default'          => 'ce_gmk_referenzen_list',
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => array('tl_content_gmk_referenzen', 'getReferenzenListTemplates'),
    'eval'             => array('tl_class' => 'w50'),
    'sql'              => "varchar(64) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['referenzenListInfiniteScrollTpl'] = array
(
    'label'            => &$GLOBALS['TL_LANG']['tl_content']['referenzenListInfiniteScrollTpl'],
    'default'          => 'ce_gmk_referenzen_list_infinite_scroll',
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => array('tl_content_gmk_referenzen', 'getReferenzenListInfiniteScrollTemplates'),
    'eval'             => array('tl_class' => 'w50'),
    'sql'              => "varchar(64) NOT NULL default ''",
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_content_gmk_referenzen extends Backend
{

    /**
     * Import the back end user object
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }


    /**
     * Return all gmk referenzen templates as array
     *
     * @return array
     */
    public function getReferenzenListTemplates()
    {
        return $this->getTemplateGroup('ce_gmk_referenzen_list');
    }


    /**
     * Return all gmk referenzen infinite scroll templates as array
     *
     * @return array
     */
    public function getReferenzenListInfiniteScrollTemplates()
    {
        return $this->getTemplateGroup('ce_gmk_referenzen_list_infinite_scroll');
    }

}