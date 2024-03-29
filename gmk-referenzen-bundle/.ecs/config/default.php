<?php

declare(strict_types=1);

use Contao\EasyCodingStandard\Fixer\TypeHintOrderFixer;
use PhpCsFixer\Fixer\Comment\HeaderCommentFixer;
use PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return static function (ECSConfig $ecsConfig): void {
    // Contao
    $ecsConfig->import(__DIR__.'../../../../../contao/easy-coding-standard/config/contao.php');

    // Customize
    $ecsConfig->skip([
        '*/Resources/contao/*',
        MethodChainingIndentationFixer::class => [
            '*/DependencyInjection/Configuration.php',
            '*/Resources/config/*.php',
        ],
        TypeHintOrderFixer::class,
    ]);

    $ecsConfig->ruleWithConfiguration(HeaderCommentFixer::class, [
        'header' => "This file is part of GMK Referenzen Bundle.\n\n(c) Marko Cupic ".date("Y")." <m.cupic@gmx.ch>\n@license LGPL-3.0+\nFor the full copyright and license information,\nplease view the LICENSE file that was distributed with this source code.\n@link https://github.com/markocupic/gmk-referenzen-bundle",
    ]);

    $ecsConfig->parallel();
    $ecsConfig->lineEnding("\n");
};

