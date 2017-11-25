<?php

namespace Markocupic\Gmk;

use Patchwork\Utf8;

class GmkMitarbeiterList extends \ContentElement
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_gmk_mitarbeiter_list';


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

            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['CTE']['gmkMitarbeiterList'][0]) . ' ###';
            //$objTemplate->title = $this->headline;
            //$objTemplate->id = $this->id;
            //$objTemplate->link = $this->name;
            //$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }
        return parent::generate();

    }


    /**
     * Generate the module
     */
    protected function compile()
    {

        $rows = array();
        if($this->gmkSelectAllPublished)
        {
            $objDb = $this->Database->prepare('SELECT * FROM tl_gmk_mitarbeiter WHERE published=? ORDER BY lastname, firstname')->execute(1);
            $arrMitarbeiter = $objDb->fetchEach('id');
        }
        else
        {
            $arrMitarbeiter = \StringUtil::deserialize($this->gmkSelectedMitarbeiter, true);
        }
        foreach ($arrMitarbeiter as $userId)
        {
            $objDb = $this->Database->prepare('SELECT * FROM tl_gmk_mitarbeiter WHERE id=? AND published=?')->execute($userId, 1);
            while ($objDb->next())
            {
                $row = $objDb->row();
                if (\Validator::isUuid($row['singleSRC']))
                {
                    $row['singleSRC'] = \StringUtil::binToUuid($row['singleSRC']);
                }
                $row['interview'] = \StringUtil::deserialize($row['interview'], true);

                $rows[] = $row;
            }
        }
        $this->Template->rows = $rows;
    }
}