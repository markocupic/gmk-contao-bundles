<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 04.12.2016
 * Time: 20:01
 */


// Onload callback
$GLOBALS['TL_DCA']['tl_content']['config'] ['onload_callback'][] = array('tl_content_gmk_mitarbeiter', 'setPalette');

// Palette
$GLOBALS['TL_DCA']['tl_content']['palettes']['gmkMitarbeiterList'] = '{type_legend},type;{mitarbeiter_legend},gmkSelectAllPublished,gmkSelectedMitarbeiter;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['gmkMitarbeiterIntroducing'] = '{type_legend},type;{mitarbeiter_legend},gmkSelectedMitarbeiter;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';

// Fields
$GLOBALS['TL_DCA']['tl_content']['fields']['gmkSelectAllPublished'] = array(
    'label'     => &$GLOBALS['TL_LANG']['tl_content']['gmkSelectAllPublished'],
    'exclude'   => true,
    'inputType' => 'checkbox',
    'eval'      => array('submitOnChange' => true),
    'sql'       => "char(1) NOT NULL default ''",
);

$GLOBALS['TL_DCA']['tl_content']['fields']['gmkSelectedMitarbeiter'] = array(
    'label'            => &$GLOBALS['TL_LANG']['tl_content']['gmkSelectedMitarbeiter'],
    'exclude'          => true,
    'inputType'        => 'checkboxWizard',
    'eval'             => array('multiple' => true, 'orderField' => 'orderGmkSelectedMitarbeiter', 'mandatory' => false),
    'sql'              => "blob NULL",
    'options_callback' => array('tl_content_gmk_mitarbeiter', 'getPublishedMitarbeiter'),
);

$GLOBALS['TL_DCA']['tl_content']['fields']['orderGmkSelectedMitarbeiter'] = array(
    'label' => &$GLOBALS['TL_LANG']['tl_content']['orderGmkSelectedMitarbeiter'],
    'sql'   => "blob NULL",
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_content_gmk_mitarbeiter extends Backend
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
     * Set palette
     */
    public function setPalette()
    {
        if (Input::get('act') == 'edit' && Input::get('id') != '')
        {
            $objContent = ContentModel::findByPk(Input::get('id'));
            if ($objContent !== null)
            {
                if ($objContent->type == 'gmkMitarbeiterList')
                {
                    if ($objContent->gmkSelectAllPublished)
                    {
                        $GLOBALS['TL_DCA']['tl_content']['palettes']['gmkMitarbeiterList'] = str_replace(',gmkSelectedMitarbeiter', '', $GLOBALS['TL_DCA']['tl_content']['palettes']['gmkMitarbeiterList']);
                    }
                }
                if ($objContent->type == 'gmkMitarbeiterIntroducing')
                {
                    $GLOBALS['TL_DCA']['tl_content']['fields']['gmkSelectedMitarbeiter']['inputType'] = 'radio';
                    $GLOBALS['TL_DCA']['tl_content']['fields']['gmkSelectedMitarbeiter']['eval']['fieldType'] = 'radio';

                }
            }
        }
    }

    /**
     * @return array
     */
    public function getPublishedMitarbeiter()
    {
        $return = array();
        $objDb = $this->Database->prepare('SELECT * FROM tl_gmk_mitarbeiter WHERE published=?')->execute(1);
        while ($objDb->next())
        {
            $function = $objDb->funktion != '' ? ' (' . $objDb->funktion . ')' : '';
            $return[$objDb->id] = $objDb->firstname . ' ' . $objDb->lastname . $function;
        }
        return $return;
    }

}