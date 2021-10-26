<?php
/**
 * Created by PhpStorm.
 * User: Marko
 * Date: 25.01.2017
 * Time: 20:07
 */

// Overwrite pageTitle and pageDescription for better SEO implementation when useing the News module
$GLOBALS['TL_HOOKS']['generatePage'][] = array('Markocupic\Gmk\GeneratePageHook', 'generatePageHook');
