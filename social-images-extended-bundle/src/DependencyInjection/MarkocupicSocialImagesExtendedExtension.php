<?php


namespace Markocupic\SocialImagesExtendedBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;


/**
 * Class MarkocupicSocialImagesExtendedExtension
 * @package Markocupic\GmkReferenzenBundle\DependencyInjection
 */
class MarkocupicSocialImagesExtendedExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );

        $loader->load('parameters.yml');
        $loader->load('listener.yml');
        $loader->load('services.yml');
    }
}
