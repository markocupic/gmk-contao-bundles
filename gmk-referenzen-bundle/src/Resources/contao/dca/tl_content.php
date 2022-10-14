<?php

declare(strict_types=1);

/*
 * This file is part of GMK Referenzen Bundle.
 *
 * (c) Marko Cupic 2022 <m.cupic@gmx.ch>
 * @license LGPL-3.0+
 * For the full copyright and license information,
 * please view the LICENSE file that was distributed with this source code.
 * @link https://github.com/markocupic/gmk-referenzen-bundle
 */

// Palette
$GLOBALS['TL_DCA']['tl_content']['palettes']['gmkReferenzenList'] = '
    {type_legend},type;
    {mitarbeiter_legend};
    {config_legend},numberOfItems,perPage,skipFirst;
    {template_legend:hide},referenzenListTpl;
    {protected_legend:hide},protected;
    {expert_legend:hide},guests,cssID,space;
    {invisible_legend:hide},invisible,start,stop
';
$GLOBALS['TL_DCA']['tl_content']['palettes']['gmkReferenzenListInfiniteScroll'] = '
    {type_legend},type;
    {mitarbeiter_legend};
    {config_legend},numberOfItems,perPage,skipFirst;
    {template_legend:hide},referenzenListInfiniteScrollTpl;
    {protected_legend:hide},protected;
    {expert_legend:hide},guests,cssID,space;
    {invisible_legend:hide},invisible,start,stop
';

$GLOBALS['TL_DCA']['tl_content']['fields']['skipFirst'] = [
    'exclude'   => true,
    'inputType' => 'text',
    'eval'      => ['rgxp' => 'natural', 'tl_class' => 'w50'],
    'sql'       => "smallint(5) unsigned NOT NULL default '0'",
];

$GLOBALS['TL_DCA']['tl_content']['fields']['referenzenListTpl'] = [
    'default'          => 'ce_gmk_referenzen_list',
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => ['tl_content_gmk_referenzen', 'getReferenzenListTemplates'],
    'eval'             => ['tl_class' => 'w50'],
    'sql'              => "varchar(64) NOT NULL default ''",
];
$GLOBALS['TL_DCA']['tl_content']['fields']['referenzenListInfiniteScrollTpl'] = [
    'default'          => 'ce_gmk_referenzen_list_infinite_scroll',
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => ['tl_content_gmk_referenzen', 'getReferenzenListInfiniteScrollTemplates'],
    'eval'             => ['tl_class' => 'w50'],
    'sql'              => "varchar(64) NOT NULL default ''",
];

/**
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_content_gmk_referenzen extends Backend
{
    /**
     * Import the back end user object.
     */
    public function __construct()
    {
        parent::__construct();
        $this->import('BackendUser', 'User');
    }

    /**
     * Return all gmk referenzen templates as array.
     *
     * @return array
     */
    public function getReferenzenListTemplates()
    {
        return $this->getTemplateGroup('ce_gmk_referenzen_list');
    }

    /**
     * Return all gmk referenzen infinite scroll templates as array.
     *
     * @return array
     */
    public function getReferenzenListInfiniteScrollTemplates()
    {
        return $this->getTemplateGroup('ce_gmk_referenzen_list_infinite_scroll');
    }
}
