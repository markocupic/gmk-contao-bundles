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

use Contao\Environment;

/*
 * Backend modules
 */
$GLOBALS['BE_MOD']['content']['referenzen'] = [
    'tables' => ['tl_gmk_referenzen'],
    'icon' => 'bundles/markocupicgmkreferenzen/images/catalog16.png',
];

/*
 * Content Elements
 */
$GLOBALS['TL_CTE']['gmk_referenzen'] = [
    'gmkReferenzenList' => 'Markocupic\Gmk\GmkReferenzenList',
    'gmkReferenzenListInfiniteScroll' => 'Markocupic\Gmk\GmkReferenzenListInfiniteScroll',
];

if (TL_MODE === 'FE' && !Environment::get('isAjaxRequest')) {
    $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/markocupicgmkreferenzen/js/referenzen_infinite_scroll.js|static';
}
