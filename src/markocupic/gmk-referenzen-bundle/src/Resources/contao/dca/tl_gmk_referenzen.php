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
 * Table tl_gmk_referenzen
 */
$GLOBALS['TL_DCA']['tl_gmk_referenzen'] = array(

    // Config
    'config'      => array(
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'onload_callback'  => array(
           array('tl_gmk_referenzen', 'setPid'),
        ),
        'sql'              => array(
            'keys' => array(
                'id' => 'primary',
                'sorting,pid' => 'index',
            ),
        ),
    ),
    // List
    'list'        => array(
        'sorting'           => array(
            'panelLayout' => 'filter;sort,search,limit',
            'mode'   => 5,
            'fields' => array('sorting'),
            'flag'   => 1,
            'paste_button_callback'		=> array('tl_gmk_referenzen', 'pasteTag'),
        ),
        'label'             => array(
            'fields' => array('name'),
            'format' => '%s',
        ),
        'global_operations' => array(
            'all' => array(
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="e"',
            ),
        ),
        'operations' => array
        (
            'edit' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['edit'],
                'href'                => 'act=edit',
                'icon'                => 'edit.gif'
            ),
            'copy' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['copy'],
                'href'                => 'act=paste&amp;mode=copy',
                'icon'                => 'copy.gif',
                'attributes'          => 'onclick="Backend.getScrollOffset()"'
            ),
            'cut' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['cut'],
                'href'                => 'act=paste&amp;mode=cut',
                'icon'                => 'cut.gif',
                'attributes'          => 'onclick="Backend.getScrollOffset()"'
            ),
            'delete' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['delete'],
                'href'                => 'act=delete',
                'icon'                => 'delete.gif',
                'attributes'          => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
                //'button_callback'     => array('tl_gmk_referenzen', 'deleteElement')
            ),
            'toggle' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['toggle'],
                'icon'                => 'visible.gif',
                'attributes'          => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback'     => array('tl_gmk_referenzen', 'toggleIcon')
            ),
            'show' => array
            (
                'label'               => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['show'],
                'href'                => 'act=show',
                'icon'                => 'show.gif'
            )
        ),
    ),

    // Palettes
    'palettes'    => array(
        '__selector__' => array('addImage','addCase'),
        'default'      => '{name_legend},name;{filter_legend},branchen,leistungsfelder;{icon_legend},addImage;{case_legend},addCase',
    ),
    // Subpalettes
    'subpalettes' => array(
        'addImage' => 'singleSRC,alt,title',
        'addCase' => 'jumpTo',

    ),
    // Fields
    'fields'      => array(
        'id'        => array(
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ),
        'pid' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'tstamp'    => array(
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ),
        'sorting' => array
        (
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ),
        'published' => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['published'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => array('mandatory' => false),
            'sql'       => "char(1) NOT NULL default ''",
        ),
        'name'      => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['name'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'flag'      => 1,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'branchen'      => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['branchen'],
            'reference' => &$GLOBALS['TL_LANG']['tl_gmk_referenzen'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'flag'      => 1,
            'inputType' => 'checkbox',
            'options' => array(
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
            ),
            'eval'      => array('multiple' => true, 'tl_class' => 'clr'),
            'sql'              => "blob NULL",
        ),
        'leistungsfelder'      => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['leistungsfelder'],
            'reference' => &$GLOBALS['TL_LANG']['tl_gmk_referenzen'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'flag'      => 1,
            'inputType' => 'checkbox',
            'options' => array(
                'leistungsfelderFilter_markenanalyse',
                'leistungsfelderFilter_markenstrategie',
                'leistungsfelderFilter_markenentwicklung',
                'leistungsfelderFilter_markenimplementierung'
            ),
            'eval'      => array('multiple' => true, 'tl_class' => 'clr'),
            'sql'              => "blob NULL",
        ),

        'addImage'  => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['addImage'],
            'exclude'   => true,
            'filter'    => true,
            'inputType' => 'checkbox',
            'eval'      => array('submitOnChange' => true),
            'sql'       => "char(1) NOT NULL default ''",
        ),
        'singleSRC' => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['singleSRC'],
            'exclude'   => true,
            'inputType' => 'fileTree',
            'eval'      => array('filesOnly' => true, 'extensions' => Config::get('validImageTypes'), 'fieldType' => 'radio', 'mandatory' => true),
            'sql'       => "binary(16) NULL",
        ),
        'alt' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['alt'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'title' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['title'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'text',
            'eval'                    => array('maxlength'=>255, 'tl_class'=>'w50'),
            'sql'                     => "varchar(255) NOT NULL default ''"
        ),
        'addCase'  => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['addCase'],
            'exclude'   => true,
            'filter'    => true,
            'inputType' => 'checkbox',
            'eval'      => array('submitOnChange' => true),
            'sql'       => "char(1) NOT NULL default ''",
        ),
        'jumpTo' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_gmk_referenzen']['jumpTo'],
            'exclude'                 => true,
            'inputType'               => 'pageTree',
            'foreignKey'              => 'tl_gmk_referenzen.title',
            'eval'                    => array('fieldType'=>'radio','mandatory' => true), // do not set mandatory (see #5453)
            'save_callback' => array
            (
                //array('tl_page', 'checkJumpTo')
            ),
            'sql'                     => "int(10) unsigned NOT NULL default '0'",
            'relation'                => array('type'=>'hasOne', 'load'=>'lazy')
        ),
    ),
);


class tl_gmk_referenzen extends Backend
{

    /**
     * Check permissions to edit table tl_gmk_referenzen
     */
    public function checkPermission()
    {
        //
    }

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
     * Return the "toggle visibility" button
     *
     * @param array $row
     * @param string $href
     * @param string $label
     * @param string $title
     * @param string $icon
     * @param string $attributes
     *
     * @return string
     */
    public function toggleIcon($row, $href, $label, $title, $icon, $attributes)
    {
        if (strlen(Input::get('tid')))
        {
            $this->toggleVisibility(Input::get('tid'), (Input::get('state') == 1), (@func_get_arg(12) ?: null));
            $this->redirect($this->getReferer());
        }

        $href .= '&amp;tid=' . $row['id'] . '&amp;state=' . ($row['published'] ? '' : 1);

        if (!$row['published'])
        {
            $icon = 'invisible.gif';
        }

        return '<a href="' . $this->addToUrl($href) . '" title="' . specialchars($title) . '"' . $attributes . '>' . Image::getHtml($icon, $label, 'data-state="' . ($row['published'] ? 1 : 0) . '"') . '</a> ';
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
    public function pasteTag(DataContainer $dc, $row, $table, $cr, $arrClipboard=false)
    {
        $this->import('BackendUser', 'User');

        $imagePasteAfter = $this->generateImage('pasteafter.gif', sprintf($GLOBALS['TL_LANG'][$dc->table]['pasteafter'][1], $row['id']));
        $imagePasteInto = $this->generateImage('pasteinto.gif', sprintf($GLOBALS['TL_LANG'][$dc->table]['pasteinto'][1], $row['id']));

        if ($row['id'] == 0)
        {
            return $cr ? $this->generateImage('pasteinto_.gif').' ' : '<a href="'.$this->addToUrl('act='.$arrClipboard['mode'].'&mode=2&pid='.$row['id'].'&id='.$arrClipboard['id']).'" title="'.specialchars(sprintf($GLOBALS['TL_LANG'][$dc->table]['pasteinto'][1], $row['id'])).'" onclick="Backend.getScrollOffset();">'.$imagePasteInto.'</a> ';
        }

        return (($arrClipboard['mode'] == 'cut' && $arrClipboard['id'] == $row['id']) || $cr) ? $this->generateImage('pasteafter_.gif').' ' : '<a href="'.$this->addToUrl('act='.$arrClipboard['mode'].'&mode=1&pid='.$row['id'].'&id='.$arrClipboard['id']).'" title="'.specialchars(sprintf($GLOBALS['TL_LANG'][$dc->table]['pasteafter'][1], $row['id'])).'" onclick="Backend.getScrollOffset();">'.$imagePasteAfter.'</a> ';
    }

    /**
     * Disable/enable a user group
     *
     * @param integer $intId
     * @param boolean $blnVisible
     * @param DataContainer $dc
     */
    public function toggleVisibility($intId, $blnVisible, DataContainer $dc = null)
    {
        // Set the ID and action
        Input::setGet('id', $intId);
        Input::setGet('act', 'toggle');

        if ($dc)
        {
            $dc->id = $intId; // see #8043
        }

        $this->checkPermission();


        $objVersions = new Versions('tl_news', $intId);
        $objVersions->initialize();

        // Trigger the save_callback
        if (is_array($GLOBALS['TL_DCA']['tl_gmk_referenzen']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_gmk_referenzen']['fields']['published']['save_callback'] as $callback)
            {
                if (is_array($callback))
                {
                    $this->import($callback[0]);
                    $blnVisible = $this->{$callback[0]}->{$callback[1]}($blnVisible, ($dc ?: $this));
                }
                elseif (is_callable($callback))
                {
                    $blnVisible = $callback($blnVisible, ($dc ?: $this));
                }
            }
        }

        // Update the database
        $this->Database->prepare("UPDATE tl_gmk_referenzen SET tstamp=" . time() . ", published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")->execute($intId);

        $objVersions->create();

    }


}
