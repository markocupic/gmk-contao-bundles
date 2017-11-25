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
 * Table tl_gmk_mitarbeiter
 */
$GLOBALS['TL_DCA']['tl_gmk_mitarbeiter'] = array(

    // Config
    'config'      => array(
        'dataContainer'    => 'Table',
        'enableVersioning' => true,
        'onload_callback'  => array(
           // array('tl_gmk_mitarbeiter', 'checkPermission'),
        ),
        'sql'              => array(
            'keys' => array(
                'id' => 'primary',
            ),
        ),
    ),
    // List
    'list'        => array(
        'sorting'           => array(
            'mode'   => 1,
            'fields' => array('lastname'),
            'flag'   => 1,
        ),
        'label'             => array(
            'fields' => array('lastname','firstname'),
            'format' => '%s %s',
        ),
        'global_operations' => array(
            'all' => array(
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="e"',
            ),
        ),
        'operations'        => array(
            'edit'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif',
            ),
            'copy'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ),
            'delete' => array(
                'label'      => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => 'onclick="if(!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\'))return false;Backend.getScrollOffset()"',
            ),
            'toggle' => array(
                'label'           => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['toggle'],
                'icon'            => 'visible.gif',
                'attributes'      => 'onclick="Backend.getScrollOffset();return AjaxRequest.toggleVisibility(this,%s)"',
                'button_callback' => array('tl_gmk_mitarbeiter', 'toggleIcon'),
            ),
            'show'   => array(
                'label' => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif',
            ),
        ),
    ),
    // Select
    'select'      => array(
        'buttons_callback' => array(),
    ),
    // Edit
    'edit'        => array(
        'buttons_callback' => array(),
    ),
    // Palettes
    'palettes'    => array(
        '__selector__' => array('addImage'),
        'default'      => '{personal_legend},firstname,lastname,funktion,description,publications,phone,email;{image_legend},addImage;{interview_legend},interview;',
    ),
    // Subpalettes
    'subpalettes' => array(
        'addImage' => 'singleSRC',
    ),
    // Fields
    'fields'      => array(
        'id'        => array(
            'sql' => "int(10) unsigned NOT NULL auto_increment",
        ),
        'tstamp'    => array(
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ),
        'published' => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['published'],
            'exclude'   => true,
            'inputType' => 'checkbox',
            'eval'      => array('mandatory' => false),
            'sql'       => "char(1) NOT NULL default ''",
        ),
        'firstname'      => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['firstname'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'flag'      => 1,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'lastname'      => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['lastname'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => true,
            'flag'      => 1,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'funktion'  => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['funktion'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => false,
            'flag'      => 1,
            'inputType' => 'text',
            'eval'      => array('mandatory' => false, 'maxlength' => 255, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'description'  => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['description'],
            'exclude'   => true,
            'search'    => true,
            'sorting'   => false,
            'flag'      => 1,
            'inputType' => 'textarea',
            'eval'      => array('mandatory' => false, 'tl_class' => 'clr'),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'publications' => array
        (
            'label'                   => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['publications'],
            'exclude'                 => true,
            'search'                  => true,
            'inputType'               => 'textarea',
            'eval'                    => array('mandatory'=>false, 'rte'=>'tinyMCE', 'helpwizard'=>true),
            'explanation'             => 'insertTags',
            'sql'                     => "mediumtext NULL"
        ),
        'phone'     => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['phone'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array('maxlength' => 64, 'rgxp' => 'phone', 'decodeEntities' => true, 'tl_class' => 'w50'),
            'sql'       => "varchar(64) NOT NULL default ''",
        ),
        'email'     => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['email'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => array('mandatory' => true, 'maxlength' => 255, 'rgxp' => 'email', 'decodeEntities' => true, 'tl_class' => 'w50'),
            'sql'       => "varchar(255) NOT NULL default ''",
        ),
        'addImage'  => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['addImage'],
            'exclude'   => true,
            'filter'    => true,
            'inputType' => 'checkbox',
            'eval'      => array('submitOnChange' => true),
            'sql'       => "char(1) NOT NULL default ''",
        ),
        'singleSRC' => array(
            'label'     => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['singleSRC'],
            'exclude'   => true,
            'inputType' => 'fileTree',
            'eval'      => array('filesOnly' => true, 'extensions' => Config::get('validImageTypes'), 'fieldType' => 'radio', 'mandatory' => true),
            'sql'       => "binary(16) NULL",
        ),
        'interview' => array
        (
            'label'			=> &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['interview'],
            'exclude' 		=> true,
            'inputType' 		=> 'multiColumnWizard',
            'eval' 			=> array
            (
                'columnFields' => array
                (

                    'interview_question' => array
                    (
                        'label'                 => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['interview_question'],
                        'exclude'               => true,
                        'inputType'             => 'text',
                        'eval' 			=> array('style'=>'width:180px')
                    ),
                    'interview_answer' => array
                    (
                        'label'                 => &$GLOBALS['TL_LANG']['tl_gmk_mitarbeiter']['interview_answer'],
                        'exclude'               => true,
                        'inputType'             => 'textarea',
                        'eval' 			=> array('style'=>'width:300px')
                    )
                )
            ),
            'sql' => "blob NULL"
        )
    ),
);


class tl_gmk_mitarbeiter extends Backend
{

    /**
     * Check permissions to edit table tl_gmk_mitarbeiter
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
        if (is_array($GLOBALS['TL_DCA']['tl_gmk_mitarbeiter']['fields']['published']['save_callback']))
        {
            foreach ($GLOBALS['TL_DCA']['tl_gmk_mitarbeiter']['fields']['published']['save_callback'] as $callback)
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
        $this->Database->prepare("UPDATE tl_gmk_mitarbeiter SET tstamp=" . time() . ", published='" . ($blnVisible ? '1' : '') . "' WHERE id=?")->execute($intId);

        $objVersions->create();

    }


}
