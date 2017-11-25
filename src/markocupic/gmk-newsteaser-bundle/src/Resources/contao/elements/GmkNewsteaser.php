<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Markocupic\Gmk;


use Patchwork\Utf8;

/**
 * Class GmkNewsteaser
 * @package Markocupic\Gmk
 */
class GmkNewsteaser extends \ContentElement
{

    /**
     * Template
     * @var string
     */
    protected $strTemplate = 'ce_gmk_newsteaser_default';

    /**
     * News Object
     * @var null
     */
    protected $objNews = null;


    /**
     * Return if the highlighter plugin is not loaded
     *
     * @return string
     */
    public function generate()
    {

        $this->objNews = \NewsModel::findByPk($this->gmk_newsteaser_news);
        if($this->objNews === null)
        {
            return '';
        }

        if (TL_MODE == 'BE')
        {

            /** @var \BackendTemplate|object $objTemplate */
            $objTemplate = new \BackendTemplate('be_wildcard');

            $objTemplate->wildcard = '### GMK-NEWS-TEASER: ' . Utf8::strtoupper($this->objNews->headline) . ' ###';


            return $objTemplate->parse();
        }

        // Switch to the gmkCase template
        if($this->type == 'gmkCase')
        {
            $this->strTemplate = 'ce_gmk_newsteaser_case';
        }

        // Overwrite strTemplate
        if($this->gmkNewsteaserTpl != '')
        {
            $this->strTemplate = $this->gmkNewsteaserTpl;
        }

        return parent::generate();
    }


    /**
     * Generate the module
     */
    protected function compile()
    {
        $row = $this->objNews->row();
        foreach($row as $k => $v)
        {
            $this->Template->$k = $v;
        }
        $this->Template->href = $this->getLink($this->objNews);
        $this->Template->date = $this->objNews->date;
        $this->Template->headline = $this->objNews->headline;
        $this->Template->teaser = $this->objNews->teaser;
    }

    /**
     * Returns a link to the detail page of a news item
     * @param $objItem
     * @return string
     * @throws \Exception
     */
    protected function getLink($objItem)
    {
        if (($objNews = \NewsModel::findByIdOrAlias($objItem->id)) === null)
        {
            return '';
        }

        $strUrl = '';

        if ($objNews->source == 'external')
        {
            $strUrl = $objNews->url;
        }
        elseif ($objNews->source == 'internal')
        {
            if (($objJumpTo = $objNews->getRelated('jumpTo')) !== null)
            {
                /** @var \PageModel $objJumpTo */
                $strUrl = $objJumpTo->getFrontendUrl();
            }
        }
        elseif ($objNews->source == 'article')
        {
            if (($objArticle = \ArticleModel::findByPk($objNews->articleId, array('eager'=>true))) !== null && ($objPid = $objArticle->getRelated('pid')) !== null)
            {
                /** @var \PageModel $objPid */
                $strUrl = $objPid->getFrontendUrl('/articles/' . ((!\Config::get('disableAlias') && $objArticle->alias != '') ? $objArticle->alias : $objArticle->id));
            }
        }
        else
        {
            if (($objArchive = $objNews->getRelated('pid')) !== null && ($objJumpTo = $objArchive->getRelated('jumpTo')) !== null)
            {
                /** @var \PageModel $objJumpTo */
                $strUrl = $objJumpTo->getFrontendUrl(((\Config::get('useAutoItem') && !\Config::get('disableAlias')) ? '/' : '/items/') . ((!\Config::get('disableAlias') && $objNews->alias != '') ? $objNews->alias : $objNews->id));
            }
        }


        return $strUrl;

    }
}