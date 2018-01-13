<?php
namespace Markocupic\Gmk;

use Patchwork\Utf8;

class GmkReferenzenList extends \ContentElement
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_gmk_referenzen_list';


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

            $objTemplate->wildcard = '### ' . Utf8::strtoupper($GLOBALS['TL_LANG']['CTE']['gmkReferenzenList'][0]) . ' ###';
            //$objTemplate->title = $this->headline;
            //$objTemplate->id = $this->id;
            //$objTemplate->link = $this->name;
            //$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        // Add custom template
        if ($this->referenzenListTpl != '')
        {
            $this->strTemplate = $this->referenzenListTpl;
        }

        return parent::generate();

    }


    /**
     * Generate the module
     */
    protected function compile()
    {
        $this->loadLanguageFile('tl_gmk_referenzen');
        $arrItems = array();

        $limit = null;
        $offset = intval($this->skipFirst);

        // Maximum number of items
        if ($this->numberOfItems > 0)
        {
            $limit = $this->numberOfItems;
        }


        // Get the total number of items
        $intTotal = $this->countItems();

        if ($intTotal < 1)
        {
            return;
        }

        $total = $intTotal - $offset;

        // Split the results
        if ($this->perPage > 0 && (!isset($limit) || $this->numberOfItems > $this->perPage))
        {
            // Adjust the overall limit
            if (isset($limit))
            {
                $total = min($limit, $total);
            }

            // Get the current page
            $id = 'page_n' . $this->id;
            $page = (\Input::get($id) !== null) ? \Input::get($id) : 1;

            // Do not index or cache the page if the page number is outside the range
            if ($page < 1 || $page > max(ceil($total / $this->perPage), 1))
            {
                /** @var \PageModel $objPage */
                global $objPage;

                /** @var \PageError404 $objHandler */
                $objHandler = new $GLOBALS['TL_PTY']['error_404']();
                $objHandler->generate($objPage->id);
            }

            // Set limit and offset
            $limit = $this->perPage;
            $offset += (max($page, 1) - 1) * $this->perPage;
            $skip = intval($this->skipFirst);

            // Overall limit
            if ($offset + $limit > $total + $skip)
            {
                $limit = $total + $skip - $offset;
            }

            // Add the pagination menu
            $objPagination = new \Pagination($total, $this->perPage, \Config::get('maxPaginationLinks'), $id);
            $this->Template->pagination = $objPagination->generate("\n  ");

        }

        $limit = $limit ?: 0;
        $objDb = $this->Database->prepare('SELECT * FROM tl_gmk_referenzen WHERE published=? ORDER BY sorting ASC LIMIT ' . $offset . ', ' . $limit)->execute(1);
        while ($objDb->next())
        {
            $item = array();
            if ($objDb->addImage)
            {

                if (\Validator::isUuid($objDb->singleSRC))
                {

                    $objFile = \FilesModel::findByUuid($objDb->singleSRC);
                    if ($objFile !== null)
                    {
                        if (is_file(TL_ROOT . '/' . $objFile->path))
                        {
                            $item['name'] = $objDb->name;

                            $item['uuid'] = \StringUtil::binToUuid($objDb->singleSRC);
                            $item['src'] = $objFile->path;
                            $item['alt'] = $objDb->alt;
                            $item['title'] = $objDb->alt;

                            // Branchen
                            $arrBranchen = deserialize($objDb->branchen, true);
                            $arrBranchenLabels = array_map(function ($key)
                            {
                                return strlen($GLOBALS['TL_LANG']['tl_gmk_referenzen'][$key]) ? $GLOBALS['TL_LANG']['tl_gmk_referenzen'][$key] : $key;
                            }, $arrBranchen);
                            $item['strBranchen'] = implode(', ', $arrBranchenLabels);
                            $item['strCSSClassesBranchen'] = implode(' ', $arrBranchen);

                            // Leistungsfelder
                            $arrLeistungsfelder = deserialize($objDb->leistungsfelder, true);
                            $arrLeistungsfelderLabels = array_map(function ($key)
                            {
                                return strlen($GLOBALS['TL_LANG']['tl_gmk_referenzen'][$key]) ? $GLOBALS['TL_LANG']['tl_gmk_referenzen'][$key] : $key;
                            }, $arrLeistungsfelder);
                            $item['strLeistungsfelder'] = implode(', ', $arrLeistungsfelderLabels);
                            $item['strCSSClassesLeistungsfelder'] = implode(' ', $arrLeistungsfelder);
                            $arrHasCase = array();

                            $blnHasCase = false;
                            if ($objDb->addCase && $objDb->jumpTo && (\PageModel::findByPk($objDb->jumpTo) !== null))
                            {
                                $oPage = \PageModel::findByPk($objDb->jumpTo);
                                $item['jumpTo'] = $oPage->getFrontendUrl();
                                $item['hasCase'] = true;
                                $blnHasCase = true;

                            }
                            if ($blnHasCase)
                            {
                                $arrHasCase[] = 'hasCase';
                            }

                            $item['filterClasses'] = implode(' ', array_merge($arrBranchen, $arrLeistungsfelder, $arrHasCase));


                            $arrItems[] = $item;
                        }
                    }
                }
            }
        }
        $this->Template->items = $arrItems;
    }


    /**
     * @return mixed
     */
    protected function countItems()
    {
        $objDb = $this->Database->prepare('SELECT id FROM tl_gmk_referenzen WHERE published=?')->execute(1);
        return $objDb->numRows;

    }


}