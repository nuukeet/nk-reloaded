<?php
if (! defined('INDEX_CHECK')) exit('No direct script access allowed');

/**
 * This file is part of the nk-reloaded project
 * A full PHP5 conversion of the Nuked-Klan CMS (Experimental)
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 *
 * @package     Nuukeet
 * @subpackage  ClassLoader
 * @author      nuukeet <nuukeet@gmail.com>
 * @copyright	Copyright (c) 2011 nk-reloaded project
 * @link	https://github.com/nuukeet/nk-reloaded
 * @version	$Id: $
 */
/**
 * @package     Nuukeet
 * @subpackage  ClassLoader
 * @author      nuukeet <nuukeet@gmail.com>
 * @copyright	Copyright (c) 2011 nk-reloaded project
 */


class ClassLoader
{
    /**
     * ClassLoader Instance
     *
     * @var ClassLoader
     */
    private static $instance = null;

    /**
     * class file extension
     *
     * @var string
     */
    protected static $classExtension = '.php';

    /**
     * namespaces
     *
     * @var string
     */
    protected static $ns ;
    
    /**
     * Loaded classes
     * @var null
     */
    protected static $loadedClasses = array();




    
    /**
     * Constructor
     */
    final function __construct()
    {
        // SPL nullify existing autoload
        spl_autoload_register(null, false);
        spl_autoload_extensions(self::$classExtension);
        spl_autoload_register(array(new self(), 'autoLoad'));
    }

    /**
     * No clone allowed
     *
     * @return void
     */
    final function __clone() {}

    /**
     * Returns current class instance
     *
     * @static
     *
     * @return Loader|null
     */
    public static function getInstance()
    {
        if(null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Recursively scans all 'libs' directories containing all needed classes
     *
     * @throws ClassLoader_Exception
     * @param $className
     *
     * @return void
     */
    public function autoLoad($className)
    {
        $directoriesIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(LIBS_ROOT), RecursiveIteratorIterator::SELF_FIRST);

        foreach($directoriesIterator as $directory) {
            if ($directory->isDir()) {
                continue;
            }

            $file = $directory->getFileName();

            self::setLoadedClassFile($file, $directory);
        }

        $this->load($className);
    }

    /**
     * Loads needed class only
     *
     * @throws Loader_Exception
     * @param $className
     * @return void
     */
    private function load($className)
    {
        $classFileName = $className . $this->getClassExtension();

        $loadedClassFile = self::getLoadedClassFile();

        if (! isset($loadedClassFile[$classFileName])) {
           throw new Loader_Exception(sprintf(' %s - [Error]: No class file "%s" found in directory %s', get_class($this), $classFileName, self::$classPath));
        }

        foreach($loadedClassFile as $classFile => $classPath) {
            if ($classPath->getFileName() == $classFileName) {

                if (! is_file($classPath->getPathName()) or ! is_readable($classPath->getPathName())) {
                    throw new ClassLoaderException(sprintf('Unable to read file %s', $classPath->getPathName()));
                }

                require_once $classPath->getPathName();

                if (! interface_exists($className, false) and ! class_exists($className, false)) {
                    throw new ClassLoaderException(sprintf('No Interface or Class "%s" found in file %s', $className, $classPath->getPathName()));
                }
            }
        }
    }

    /**
     * Sets class file extension
     *
     * @static
     * @param $extension The file extension to find
     *
     * @return void
     */
    public static function setClassExtension($extension)
    {
        self::$classExtension = $extension;
    }

    /**
     * Returns class file extension
     *
     * @static
     *
     * @return string
     */
    public static function getClassExtension()
    {
        return self::$classExtension;
    }

    /**
     * Sets an array of classes to load
     *
     * @static
     * @param $class The class file name
     * @param $path The class file path
     *
     * @return void
     */
    private static function setLoadedClassFile($class, $path)
    {
         self::$loadedClass[$class] = $path;
    }


    public static function getLoadedClassFile()
    {
        return self::$loadedClass;
    }
}