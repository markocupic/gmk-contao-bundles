<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 25.01.2017
 * Time: 20:08
 */

namespace Markocupic\Gmk;


class GeneratePageHook
{
    public function generatePageHook($objPage, $objLayout, $objPageRegular)
    {

        // Overwrite pageTitle and pageDescription
        if($objPage->myPageTitle != '')
        {
            $objPage->pageTitle = $objPage->myPageTitle;
        }
        if($objPage->myPageDescription != '')
        {
            $objPage->description = $objPage->myPageDescription;
        }
    }
}

