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

use Contao\Config;
use Contao\DataContainer;
use Contao\DC_Table;
use Contao\Image;
use Contao\StringUtil;

$GLOBALS['TL_DCA']['tl_gmk_referenzen'] = [
    'config'      => [
        'dataContainer'    => DC_Table::class,
        'enableVersioning' => true,
        'onload_callback'  => [
            ['tl_gmk_referenzen', 'setPid'],
        ],
        'sql'              => [
            'keys' => [
                'id'          => 'primary',
                'sorting,pid' => 'index',
            ],
        ],
    ],
    'list'        => [
        'sorting'           => [
            'panelLayout'           => 'filter;sort,search,limit',
            'mode'                  => DataContainer::MODE_TREE,
            'fields'                => ['sorting'],
            'flag'                  => DataContainer::SORT_INITIAL_LETTER_ASC,
            'paste_button_callback' => ['tl_gmk_referenzen', 'pasteTag'],
        ],
        'label'             => [
            'fields' => ['name'],
            'format' => '%s',
        ],
        'global_operations' => [
            'all' => [
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="e"',
            ],
        ],
        'operations'        => [
            'edit'   => [
                'href' => 'act=edit',
                'icon' => 'edit.gif',
            ],
            'copy'   => [
                'href'       => 'act=paste&amp;mode=copy',
                'icon'       => 'copy.gif',
                'attributes' => 'onclick="Backend.getScrollOffset()"',
            ],
            'cut'    => [
                'href'       => 'act=paste&amp;mode=cut',
                'icon'       => 'cut.gif',
                'attributes' => 'onclick="Backend.getScrollOffset()"',
            ],
            'delete' => [
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\''.($GLOBALS['TL_LANG']['MSC']['deleteConfirm'] ?? null).'\'))return false;Backend.getScrollOffset()"',
            ],
            'toggle' => [
                'href'    => 'act=toggle&amp;field=published',
                'icon'    => 'visible.svg',
                'reverse' => false,
            ],
            'show'   => [
                'href' => 'act=show',
                'icon' => 'show.gif',
            ],
        ],
    ],
    'palettes'    => [
        '__selector__' => ['addImage', 'addCase'],
        'default'      => '
            {name_legend},name;
            {filter_legend},branchen,leistungsfelder;
            {icon_legend},addImage;
            {case_legend},addCase
        ',
    ],
    'subpalettes' => [
        'addImage' => 'singleSRC,alt,title',
        'addCase'  => 'jumpTo',
    ],
    'fields'      => [
        'id'              => [
            'sql' => 'int(10) unsigned NOT NULL auto_increment',
        ],
        'pid'             => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'tstamp'          => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'sorting'         => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'published'       => [
            'toggle'    => true,
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => ['mandatory' => false],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'name'            => [
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'flag'      => DataContainer::SORT_INITIAL_LETTER_ASC,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'branchen'        => [
            'reference' => &$GLOBALS['TL_LANG']['tl_gmk_referenzen'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'flag'      => DataContainer::SORT_INITIAL_LETTER_ASC,
            'inputType' => 'checkbox',
            'options'   => [
                'branchenFilter_auto',
                'branchenFilter_beratung',
                'branchenFilter_chemie',
                'branchenFilter_energie',
                'branchenFilter_einrichtung',
                'branchenFilter_finanzen',
                'branchenFilter_industrie',
                'branchenFilter_it',
                'branchenFilter_konsum',
                'branchenFilter_institutionen',
                'branchenFilter_kultur',
                'branchenFilter_digitaleMedien',
                'branchenFilter_pharma',
                'branchenFilter_retail',
                'branchenFilter_tourismus',
            ],
            'eval'      => ['multiple' => true, 'tl_class' => 'clr'],
            'sql'       => 'blob NULL',
        ],
        'leistungsfelder' => [
            'reference' => &$GLOBALS['TL_LANG']['tl_gmk_referenzen'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'flag'      => DataContainer::SORT_INITIAL_LETTER_ASC,
            'inputType' => 'checkbox',
            'options'   => [
                'leistungsfelderFilter_markenanalyse',
                'leistungsfelderFilter_markenstrategie',
                'leistungsfelderFilter_markenentwicklung',
                'leistungsfelderFilter_markenimplementierung',
            ],
            'eval'      => ['multiple' => true, 'tl_class' => 'clr'],
            'sql'       => 'blob NULL',
        ],
        'addImage'        => [
            'exclude'   => true,
            'filter'    => true,
            'inputType' => 'checkbox',
            'eval'      => ['submitOnChange' => true],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'singleSRC'       => [
            'exclude'   => true,
            'inputType' => 'fileTree',
            'eval'      => ['filesOnly' => true, 'extensions' => Config::get('validImageTypes'), 'fieldType' => 'radio', 'mandatory' => true],
            'sql'       => 'binary(16) NULL',
        ],
        'alt'             => [
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'title'           => [
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => ['maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''",
        ],
        'addCase'         => [
            'exclude'   => true,
            'filter'    => true,
            'inputType' => 'checkbox',
            'eval'      => ['submitOnChange' => true],
            'sql'       => "char(1) NOT NULL default ''",
        ],
        'jumpTo'          => [
            'exclude'    => true,
            'inputType'  => 'pageTree',
            'foreignKey' => 'tl_gmk_referenzen.title',
            'eval'       => ['fieldType' => 'radio', 'mandatory' => true], // do not set mandatory (see #5453)
            'sql'        => "int(10) unsigned NOT NULL default '0'",
            'relation'   => ['type' => 'hasOne', 'load' => 'lazy'],
        ],
    ],
];

class tl_gmk_referenzen extends Backend
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
     * Pid has to be allways 0
     */
    public function setPid()
    {
        $this->Database->prepare('UPDATE tl_gmk_referenzen SET pid=?')->execute(0);
    }

    /**
     * Prevent that an item obtains a pid > 0
     * https://community.contao.org/de/showthread.php?23343-Sortierung-mit-list-gt-sorting-gt-mode-1
     * Return the paste button
     * @param object
     * @param array
     * @param string
     * @param boolean
     * @param array
     * @return string
     */
    public function pasteTag(DataContainer $dc, $row, $table, $cr, $arrClipboard = false)
    {
        $this->import('BackendUser', 'User');

        $imagePasteAfter = $this->generateImage('pasteafter.gif', sprintf($GLOBALS['TL_LANG'][$dc->table]['pasteafter'][1], $row['id']));
        $imagePasteInto = $this->generateImage('pasteinto.gif', sprintf($GLOBALS['TL_LANG'][$dc->table]['pasteinto'][1], $row['id']));

        if ($row['id'] == 0) {
            return $cr ? Image::getHtml('pasteinto_.gif').' ' : '<a href="'.$this->addToUrl('act='.$arrClipboard['mode'].'&mode=2&pid='.$row['id'].'&id='.$arrClipboard['id']).'" title="'.StringUtil::specialchars(sprintf($GLOBALS['TL_LANG'][$dc->table]['pasteinto'][1], $row['id'])).'" onclick="Backend.getScrollOffset();">'.$imagePasteInto.'</a> ';
        }

        return (($arrClipboard['mode'] == 'cut' && $arrClipboard['id'] == $row['id']) || $cr) ? Image::getHtml('pasteafter_.gif').' ' : '<a href="'.$this->addToUrl('act='.$arrClipboard['mode'].'&mode=1&pid='.$row['id'].'&id='.$arrClipboard['id']).'" title="'.StringUtil::specialchars(sprintf($GLOBALS['TL_LANG'][$dc->table]['pasteafter'][1], $row['id'])).'" onclick="Backend.getScrollOffset();">'.$imagePasteAfter.'</a> ';
    }

}
