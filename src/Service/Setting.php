<?php

/*
 * This file is part of the Symfony.AM Project.
 *
 * @author Tigran Azatyan <tigran@azatyan.info>
 *
 * @copyright Symfony.AM - 2016
 */

namespace src\SettingBundle\Service;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class Setting.
 */
class Setting
{
    /**
     * @var \Symfony\Component\DependencyInjection\Container
     */
    private $container;

    /**
     * @var
     */
    private $dbSettings;

    /**
     * @var mixed
     */
    private $configurations;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->dbSettings = $this->container
            ->get('doctrine')->getManager()
            ->getRepository('SettingBundle:Setting')->findAll();

        $this->configurations = $this->container->getParameter('project');
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function get($key)
    {
        foreach ($this->dbSettings as $setting) {
            if ($setting->getTitle() == $key) {
                return $setting->getSetting();
            }
        }

        return $this->getConfig($key);
    }

    /**
     * @param $key
     *
     * @return mixed
     *
     * @throws \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function getConfig($key)
    {
        if (array_key_exists($key, $this->configurations)) {
            return $this->configurations[$key];
        } else {
            throw new InvalidConfigurationException('Please add '.$key.' to settings');
        }
    }
}
