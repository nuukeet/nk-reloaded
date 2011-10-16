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

class ClassLoader_Exception extends Exception {}

class ClassLoader
{
    /**
     * class Instance
     *
     * @var Loader
     */
    private static $instance = null;

    /**
     * class file extension 
     *
     * @var string
     */
    protected static $classExtension = '.php';

    /**
     * class directory path
     *
     * @var string
     */
    protected static $classPath;

    /**
     * @var null
     */
    protected static $loadedClass = array();




    
    /**
     * Constructor
     */
    final function __construct() {}

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
     * Initializes spl_autoload_register
     *
     * @static
     *
     * @return void
     */
    public static function register(DirectoryMapper $directoryMapper)
    {
        self::setClassExtension(self::$classExtension);
        self::$classPath = $directoryMapper->getDirectories();
        spl_autoload_extensions(self::$classExtension);
        spl_autoload_register(array(new self(), 'classAutoLoad'));
    }

    /**
     * Recursively scans all 'libs' directories containing all needed classes
     *
     * @throws Loader_Exception
     * @param $className
     *
     * @return void
     */
    public function classAutoLoad($className)
    {
        $directories = array();
        
        foreach(self::$classPath as $path) {       
            $directories[$path] = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path), RecursiveIteratorIterator::SELF_FIRST);
        }

        foreach($directories as $path => $directory) {

            if ($directory->isDir()) {
                continue;
            }

            $file = $directory->getFileName();

            self::setLoadedClassFile($file, $directory);
        }

        $this->load($className);
    }

    /**
     * Load needed class only
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

        foreach($loadedClassFile as $file => $path) {
            if ($path->getFileName() == $classFileName) {

                if (! is_file($path->getPathName()) or ! is_readable($path->getPathName())) {
                    throw new Loader_Exception(sprintf('Unable to read file %s', $path->getPathName()));
                }

                require_once $path->getPathName();

                if (! interface_exists($className, false) and ! class_exists($className, false)) {
                    throw new Loader_Exception(sprintf('No Interface or Class "%s" found in file %s', $className, $path->getPathName()));
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
