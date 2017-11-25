<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 05.06.2017
 * Time: 20:02
 */

namespace Markocupic;


class SocialImagesExtended extends \Controller
{
    /**
     * Collect the images from news (parseArticles-Hook)
     * @param object
     * @param array
     */
    public function collectNewsImages($objTemplate, $arrData, $objModule)
    {
        if ($arrData['socialImage'])
        {
            $objFile = \FilesModel::findByPk($arrData['socialImage']);

            if ($objFile !== null && is_file(TL_ROOT . '/' . $objFile->path))
            {
                // Initialize the array
                if (!is_array($GLOBALS['SOCIAL_IMAGES']))
                {
                    $GLOBALS['SOCIAL_IMAGES'] = array();
                }
                array_unshift($GLOBALS['SOCIAL_IMAGES'], $objFile->path);
            }
        }
    }
}