<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 03.12.2016
 * Time: 23:00
 */
$GLOBALS['TL_DCA']['tl_content']['palettes']['gmkNewsteaser'] = '{title_legend},name,type;{newssetting_legend},gmk_newsteaser_archive,gmk_newsteaser_news;{template_legend:hide},gmkNewsteaserTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['gmkCase'] = '{title_legend},name,type;{newssetting_legend},gmk_newsteaser_archive,gmk_newsteaser_news;{template_legend:hide},gmkNewsteaserTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID,space;{invisible_legend:hide},invisible,start,stop';


$GLOBALS['TL_DCA']['tl_content']['fields']['gmk_newsteaser_archive'] = array(

    'label'            => &$GLOBALS['TL_LANG']['tl_content']['gmk_newsteaser_archive'],
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => array('tl_content_gmk_newsteaser', 'listNewsArchives'),
    'reference'        => &$GLOBALS['TL_LANG']['tl_content'],
    'eval'             => array('submitOnChange' => true),
    'sql'              => "varchar(32) NOT NULL default ''",
);
$GLOBALS['TL_DCA']['tl_content']['fields']['gmk_newsteaser_news'] = array(

    'label'            => &$GLOBALS['TL_LANG']['tl_content']['gmk_newsteaser_news'],
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => array('tl_content_gmk_newsteaser', 'listNews'),
    'reference'        => &$GLOBALS['TL_LANG']['tl_content'],
    'sql'              => "varchar(32) NOT NULL default ''",

);

$GLOBALS['TL_DCA']['tl_content']['fields']['gmkNewsteaserTpl'] = array(

    'label'            => &$GLOBALS['TL_LANG']['tl_content']['gmkNewsteaserTpl'],
    'exclude'          => true,
    'inputType'        => 'select',
    'options_callback' => array('tl_content_gmk_newsteaser', 'getGmkNewsteaserTemplates'),
    'eval'             => array('includeBlankOption'=>true, 'chosen'=>true, 'tl_class'=>'w50'),
    'sql'              => "varchar(64) NOT NULL default ''",
);


/**
 * Provide miscellaneous methods that are used by the data configuration array.
 *
 * @author Leo Feyer <https://github.com/leofeyer>
 */
class tl_content_gmk_newsteaser extends Backend
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
     * options_callback
     * list news archives
     */
    public function listNewsArchives()
    {
        $arrArchive = array();
        $objArchive = $this->Database->execute('SELECT * FROM tl_news_archive ORDER BY id');
        while ($objArchive->next())
        {
            $arrArchive[$objArchive->id] = $objArchive->title;
        }
        return $arrArchive;
    }

    /**
     * options_callback
     * list news archives
     */
    public function listNews()
    {
        $arrNews = array();
        $objContent = ContentModel::findByPk(Input::get('id'));
        if ($objContent !== null)
        {
            if ($objContent->gmk_newsteaser_archive > 0)
            {
                $pid = $objContent->gmk_newsteaser_archive;
            }
            else
            {
                $objArchive = $this->Database->prepare('SELECT * FROM tl_news_archive ORDER BY id')->limit(1)->execute();
                if ($objArchive->numRows < 1)
                {
                    return $arrNews;
                }
                $pid = $objArchive->id;
            }

            $objArchive = $this->Database->prepare('SELECT * FROM tl_news WHERE pid=? AND published=? ORDER BY id')->execute($pid, '1');
            while ($objArchive->next())
            {

                $objCe = $this->Database->prepare('SELECT * FROM tl_content WHERE ptable=? AND pid=?')->execute('tl_news', $objArchive->id);
                if ($objCe->numRows)
                {
                    $arrNews[$objArchive->id] = $objArchive->headline;
                }
            }
        }

        return $arrNews;
    }


    /**
     * Return all newsteaser templates as array
     *
     * @return array
     */
    public function getGmkNewsteaserTemplates()
    {
        return $this->getTemplateGroup('ce_gmk_newsteaser_');
    }
}
