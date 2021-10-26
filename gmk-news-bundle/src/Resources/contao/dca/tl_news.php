<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 03.12.2016
 * Time: 23:00
 */
$GLOBALS['TL_DCA']['tl_news']['palettes']['__selector__'][] = 'addIcon';
$GLOBALS['TL_DCA']['tl_news']['subpalettes']['addIcon'] = 'iconSingleSRC,iconAlt,iconSize,iconMargin,iconUrl,iconFullsize,iconCaption,iconFloating';
$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace('addImage;','addImage;{icon_settings},addIcon;', $GLOBALS['TL_DCA']['tl_news']['palettes']['default']);
$GLOBALS['TL_DCA']['tl_news']['palettes']['default'] = str_replace('{image_legend','{meta_settings},metaTitle,metaDescription;{image_legend', $GLOBALS['TL_DCA']['tl_news']['palettes']['default']);



$GLOBALS['TL_DCA']['tl_news']['fields']['metaTitle'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['metaTitle'],
    'exclude'                 => true,
    'inputType'               => 'text',
    'search'                  => true,
    'eval'                    => array('maxlength'=>255, 'decodeEntities'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_news']['fields']['metaDescription'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['metaDescription'],
    'exclude'                 => true,
    'inputType'               => 'textarea',
    'search'                  => true,
    'eval'                    => array('style'=>'height:60px', 'decodeEntities'=>true, 'tl_class'=>'clr'),
    'sql'                     => "text NULL"
);

$GLOBALS['TL_DCA']['tl_news']['fields']['addIcon'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['addIcon'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('submitOnChange'=>true),
    'sql'                     => "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_news']['fields']['iconSingleSRC'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['iconSingleSRC'],
    'exclude'                 => true,
    'inputType'               => 'fileTree',
    'eval'                    => array('filesOnly'=>true, 'extensions'=>Config::get('validImageTypes'), 'fieldType'=>'radio', 'mandatory'=>true),
    'save_callback' => array
    (
        array('tl_news', 'storeFileMetaInformation')
    ),
    'sql'                     => "binary(16) NULL"
);
$GLOBALS['TL_DCA']['tl_news']['fields']['iconAlt'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['iconAlt'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'tl_class'=>'long'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_news']['fields']['iconSize'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['iconSize'],
    'exclude'                 => true,
    'inputType'               => 'imageSize',
    'options_callback' => function ()
    {
        return System::getContainer()->get('contao.image.image_sizes')->getOptionsForUser(BackendUser::getInstance());
    },
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'eval'                    => array('rgxp'=>'natural', 'includeBlankOption'=>true, 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(64) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_news']['fields']['iconMargin'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['iconMargin'],
    'exclude'                 => true,
    'inputType'               => 'trbl',
    'options'                 => $GLOBALS['TL_CSS_UNITS'],
    'eval'                    => array('includeBlankOption'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(128) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_news']['fields']['iconUrl'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['iconUrl'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'text',
    'eval'                    => array('rgxp'=>'url', 'decodeEntities'=>true, 'maxlength'=>255, 'fieldType'=>'radio', 'filesOnly'=>true, 'tl_class'=>'w50 wizard'),
    'wizard' => array
    (
        array('tl_news', 'pagePicker')
    ),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_news']['fields']['iconFullsize'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['iconFullsize'],
    'exclude'                 => true,
    'inputType'               => 'checkbox',
    'eval'                    => array('tl_class'=>'w50 m12'),
    'sql'                     => "char(1) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_news']['fields']['iconCaption'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['iconCaption'],
    'exclude'                 => true,
    'search'                  => true,
    'inputType'               => 'text',
    'eval'                    => array('maxlength'=>255, 'allowHtml'=>true, 'tl_class'=>'w50'),
    'sql'                     => "varchar(255) NOT NULL default ''"
);
$GLOBALS['TL_DCA']['tl_news']['fields']['iconFloating'] = array
(
    'label'                   => &$GLOBALS['TL_LANG']['tl_news']['iconFloating'],
    'default'                 => 'above',
    'exclude'                 => true,
    'inputType'               => 'radioTable',
    'options'                 => array('above', 'left', 'right', 'below'),
    'eval'                    => array('cols'=>4, 'tl_class'=>'w50'),
    'reference'               => &$GLOBALS['TL_LANG']['MSC'],
    'sql'                     => "varchar(12) NOT NULL default ''"
);