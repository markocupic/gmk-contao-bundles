<?php

namespace Markocupic\Gmk;

use Patchwork\Utf8;

/**
 * Class GmkMitarbeiterIntroducing
 * @package Markocupic\Gmk
 */
class GmkMitarbeiterIntroducing extends \ContentElement
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_gmk_mitarbeiter_introducing';


    /**
     * Do not display the module if there are no articles
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE == 'BE')
        {
            /** @var \BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate('be_wildcard');
            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['CTE']['gmkMitarbeiterIntroducing'][0]) . ' ###';
            return $objTemplate->parse();
        }
        $userId = $this->gmkSelectedMitarbeiter;

        $objDb = $this->Database->prepare('SELECT * FROM tl_gmk_mitarbeiter WHERE id=? AND published=?')->execute($userId, 1);
        if(!$objDb->numRows)
        {
            return '';
        }
        $this->objUser = $objDb;


        return parent::generate();

    }


    /**
     * Generate the module
     */
    protected function compile()
    {
        $row =  $this->objUser->row();
        if (\Validator::isUuid($row['singleSRC']))
        {
            $row['singleSRC'] = \StringUtil::binToUuid($row['singleSRC']);
        }
        $row['interview'] = \StringUtil::deserialize($row['interview'], true);

        $this->Template->row = $row;
    }
}