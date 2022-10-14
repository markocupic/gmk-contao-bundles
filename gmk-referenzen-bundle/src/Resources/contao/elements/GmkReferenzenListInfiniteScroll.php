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

namespace Markocupic\Gmk;

use Contao\BackendTemplate;
use Contao\Config;
use Contao\Environment;
use Contao\FilesModel;
use Contao\Input;
use Contao\PageError404;
use Contao\PageModel;
use Contao\Pagination;
use Contao\StringUtil;
use Contao\Validator;
use Patchwork\Utf8;

class GmkReferenzenListInfiniteScroll extends \ContentElement
{
    protected string $strTemplate = 'ce_gmk_referenzen_list_infinite_scroll';

    /**
     * Do not display the module if there are no articles.
     *
     * @return string
     */
    public function generate()
    {
        if (TL_MODE === 'BE') {
            $objTemplate = new BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### '.Utf8::strtoupper($GLOBALS['TL_LANG']['CTE']['gmkReferenzenListInfiniteScroll'][0]).' ###';
            //$objTemplate->title = $this->headline;
            //$objTemplate->id = $this->id;
            //$objTemplate->link = $this->name;
            //$objTemplate->href = 'contao/main.php?do=themes&amp;table=tl_module&amp;act=edit&amp;id=' . $this->id;

            return $objTemplate->parse();
        }

        if (Environment::get('isAjaxRequest')) {
            /** @var PageModel $objPage */
            global $objPage;

            $objPage->noSearch = 1;
            $objPage->cache = 0;
        }

        // Add custom template
        if ('' !== $this->referenzenListInfiniteScrollTpl) {
            $this->strTemplate = $this->referenzenListInfiniteScrollTpl;
        }

        return parent::generate();
    }

    /**
     * Generate the module.
     */
    protected function compile(): void
    {
        $this->loadLanguageFile('tl_gmk_referenzen');
        $arrItems = [];

        $limit = null;
        $offset = (int) ($this->skipFirst);

        // Maximum number of items
        if ($this->numberOfItems > 0) {
            $limit = $this->numberOfItems;
        }

        // Get the total number of items
        $intTotal = $this->countItems();

        if ($intTotal < 1) {
            return;
        }

        $total = $intTotal - $offset;

        // Split the results
        if ($this->perPage > 0 && (!isset($limit) || $this->numberOfItems > $this->perPage)) {
            // Adjust the overall limit
            if (isset($limit)) {
                $total = min($limit, $total);
            }

            // Get the current page
            $id = 'page_n'.$this->id;
            $page = null !== Input::get($id) ? Input::get($id) : 1;

            // Do not index or cache the page if the page number is outside the range
            if ($page < 1 || $page > max(ceil($total / $this->perPage), 1)) {
                /** @var PageModel $objPage */
                global $objPage;

                /** @var PageError404 $objHandler */
                $objHandler = new $GLOBALS['TL_PTY']['error_404']();
                $objHandler->generate($objPage->id);
            }

            // Set limit and offset
            $limit = $this->perPage;
            $offset += (max($page, 1) - 1) * $this->perPage;
            $skip = (int) ($this->skipFirst);

            // Overall limit
            if ($offset + $limit > $total + $skip) {
                $limit = $total + $skip - $offset;
            }

            // Add the pagination menu
            $objPagination = new Pagination($total, $this->perPage, Config::get('maxPaginationLinks'), $id);
            $this->Template->pagination = $objPagination->generate("\n  ");
        }

        if (!Environment::get('isAjaxRequest')) {
            // Generate hidden items
            $ids = [];
            $limit = $limit ?: 0;
            $objDb = $this->Database->prepare('SELECT * FROM tl_gmk_referenzen WHERE published=? ORDER BY sorting ASC LIMIT '.$offset.', '.$limit)->execute(1);

            while ($objDb->next()) {
                $ids[] = $objDb->id;
            }
            $js = sprintf('[%s]', implode(',', $ids));
            $this->Template->ids = $js;
        } else {
            if (Input::get('ids')) {
                $ids = explode('-', Input::get('ids'));
                $strIds = implode(',', $ids);
                $objDb = $this->Database->prepare('SELECT * FROM tl_gmk_referenzen WHERE id IN('.$strIds.') ORDER BY sorting ASC')->execute();
            } else {
                $limit = $limit ?: 0;
                $objDb = $this->Database->prepare('SELECT * FROM tl_gmk_referenzen WHERE published=? ORDER BY sorting ASC LIMIT '.$offset.', '.$limit)->execute(1);
            }

            $ids = [];
            // Add the articles
            while ($objDb->next()) {
                $item = [];

                if ($objDb->addImage) {
                    if (Validator::isUuid($objDb->singleSRC)) {
                        $objFile = FilesModel::findByUuid($objDb->singleSRC);

                        if (null !== $objFile) {
                            if (is_file(TL_ROOT.'/'.$objFile->path)) {
                                $item['name'] = $objDb->name;

                                $item['uuid'] = StringUtil::binToUuid($objDb->singleSRC);
                                $item['src'] = $objFile->path;
                                $item['alt'] = $objDb->alt;
                                $item['title'] = $objDb->alt;

                                // Branchen
                                $arrBranchen = StringUtil::deserialize($objDb->branchen, true);
                                $arrBranchenLabels = array_map(static fn ($key) => \strlen($GLOBALS['TL_LANG']['tl_gmk_referenzen'][$key]) ? $GLOBALS['TL_LANG']['tl_gmk_referenzen'][$key] : $key, $arrBranchen);
                                $item['strBranchen'] = implode(', ', $arrBranchenLabels);
                                $item['strCSSClassesBranchen'] = implode(' ', $arrBranchen);

                                // Leistungsfelder
                                $arrLeistungsfelder = StringUtil::deserialize($objDb->leistungsfelder, true);
                                $arrLeistungsfelderLabels = array_map(static fn ($key) => \strlen($GLOBALS['TL_LANG']['tl_gmk_referenzen'][$key]) ? $GLOBALS['TL_LANG']['tl_gmk_referenzen'][$key] : $key, $arrLeistungsfelder);
                                $item['strLeistungsfelder'] = implode(', ', $arrLeistungsfelderLabels);
                                $item['strCSSClassesLeistungsfelder'] = implode(' ', $arrLeistungsfelder);
                                $arrHasCase = [];

                                $blnHasCase = false;

                                if ($objDb->addCase && $objDb->jumpTo && (null !== PageModel::findByPk($objDb->jumpTo))) {
                                    $oPage = PageModel::findByPk($objDb->jumpTo);
                                    $item['jumpTo'] = $oPage->getFrontendUrl();
                                    $item['hasCase'] = true;
                                    $blnHasCase = true;
                                }

                                if ($blnHasCase) {
                                    $arrHasCase[] = 'hasCase';
                                }

                                $item['filterClasses'] = implode(' ', array_merge($arrBranchen, $arrLeistungsfelder, $arrHasCase));

                                $arrItems[] = $item;
                                $ids[] = $objDb->id;
                            }
                        }
                    }
                }
            }
            $this->Template->items = $arrItems;
            echo 'success';
            echo '***####***####***';
            echo implode(',', $ids);
            echo '***####***####***';
            $this->Template->output();
            exit();
        }

        $limit = $limit ?: 0;
        $objDb = $this->Database->prepare('SELECT * FROM tl_gmk_referenzen WHERE published=? LIMIT '.$offset.', '.$limit)->execute(1);

        while ($objDb->next()) {
            $item = [];

            if ($objDb->addImage) {
                if (Validator::isUuid($objDb->singleSRC)) {
                    $objFile = FilesModel::findByUuid($objDb->singleSRC);

                    if (null !== $objFile) {
                        if (is_file(TL_ROOT.'/'.$objFile->path)) {
                            $item['name'] = $objDb->name;

                            $item['uuid'] = StringUtil::binToUuid($objDb->singleSRC);
                            $item['src'] = $objFile->path;
                            $item['alt'] = $objDb->alt;
                            $item['title'] = $objDb->alt;

                            // Branchen
                            $arrBranchen = StringUtil::deserialize($objDb->branchen, true);
                            $arrBranchenLabels = array_map(static fn ($key) => \strlen($GLOBALS['TL_LANG']['tl_gmk_referenzen'][$key]) ? $GLOBALS['TL_LANG']['tl_gmk_referenzen'][$key] : $key, $arrBranchen);
                            $item['strBranchen'] = implode(', ', $arrBranchenLabels);
                            $item['strCSSClassesBranchen'] = implode(' ', $arrBranchen);

                            // Leistungsfelder
                            $arrLeistungsfelder = StringUtil::deserialize($objDb->leistungsfelder, true);
                            $arrLeistungsfelderLabels = array_map(static fn ($key) => \strlen($GLOBALS['TL_LANG']['tl_gmk_referenzen'][$key]) ? $GLOBALS['TL_LANG']['tl_gmk_referenzen'][$key] : $key, $arrLeistungsfelder);
                            $item['strLeistungsfelder'] = implode(', ', $arrLeistungsfelderLabels);
                            $item['strCSSClassesLeistungsfelder'] = implode(' ', $arrLeistungsfelder);
                            $arrHasCase = [];

                            $blnHasCase = false;

                            if ($objDb->addCase && $objDb->jumpTo && (null !== PageModel::findByPk($objDb->jumpTo))) {
                                $oPage = PageModel::findByPk($objDb->jumpTo);
                                $item['jumpTo'] = $oPage->getFrontendUrl();
                                $item['hasCase'] = true;
                                $blnHasCase = true;
                            }

                            if ($blnHasCase) {
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
