<?php

/*
 * This file is part of the Symfony.AM Project.
 *
 * @author Tigran Azatyan <tigran@azatyan.info>
 *
 * @copyright Symfony.AM - 2016
 */

namespace SettingBundle\Twig;

use Symfony\Component\DependencyInjection\Container;

/**
 * Class SettingExtension.
 */
class SettingExtension extends \Twig_Extension
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            'getSetting' => new \Twig_SimpleFunction('getSetting',[$this, 'getSetting']),
        ];
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function getSetting($key)
    {
        return $this->container->get('settings')->get($key);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'setting_extension';
    }
}
