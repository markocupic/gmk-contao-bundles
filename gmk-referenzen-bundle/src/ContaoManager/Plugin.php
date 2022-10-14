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

namespace Markocupic\GmkReferenzenBundle\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

/**
 * Plugin for the Contao Manager.
 */
class Plugin implements BundlePluginInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create('Markocupic\GmkReferenzenBundle\MarkocupicGmkReferenzenBundle')
                ->setLoadAfter([
                    'Contao\CoreBundle\ContaoCoreBundle',
                ]),
        ];
    }
}
