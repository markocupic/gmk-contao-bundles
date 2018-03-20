<?php
/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2016 Leo Feyer
 *
 * @license LGPL-3.0+
 */

namespace Markocupic\Gmk;

use Codefog\NewsCategoriesBundle\Model\NewsCategoryModel;
use Contao\Database;
use Contao\NewsModel;

class GmkNewsteaserHelper
{
    /**
     * @param $newsId
     * @return array
     */
    public static function getNewscategoriesFrontendTitleByNewsId($newsId)
    {
        $arrReturn = [];
        $objNews = NewsModel::findByPk($newsId);
        if ($objNews !== null)
        {
            $objNewsCategories = Database::getInstance()->prepare('SELECT * FROM tl_news_categories WHERE news_id=?')->execute($newsId);
            while ($objNewsCategories->next())
            {
                $objCategoryModel = NewsCategoryModel::findByPk($objNewsCategories->category_id);
                if ($objCategoryModel !== null)
                {
                    $arrReturn[] = $objCategoryModel->frontendTitle != '' ? $objCategoryModel->frontendTitle : $objCategoryModel->title;
                }
            }
        }

        return $arrReturn;
    }
}