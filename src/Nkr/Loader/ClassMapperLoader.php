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
 * @subpackage  ClassMapperLoader
 * @author      nuukeet <nuukeet@gmail.com>
 * @copyright	Copyright (c) 2011 nk-reloaded project 
 * @link	https://github.com/nuukeet/nk-reloaded
 * @version	$Id: $
 */
/**
 * @package     Nuukeet
 * @subpackage  ClassMapperLoader
 * @author      nuukeet <nuukeet@gmail.com>
 * @copyright	Copyright (c) 2011 nk-reloaded project 
 */

include_once realpath(dirname(__FILE__)) . '/ClassMapper/ClassMapper.php';
include_once realpath(dirname(__FILE__)) . '/Exception/ClassLoaderException.php';

class ClassMapperLoader
{
    /**
     * ClassMapperLoader Instance
     *
     * @var ClassMapperLoader
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
    protected static $ns;

    /**
     * Loaded classes
     * @var null
     */
    protected static $loadedClasses = array();




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
        if (null === self::$instance) {
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
    public static function register()
    {
        $classMapper = new ClassMapper();
        self::setClassExtension(self::$classExtension);
        self::$ns = $classMapper::getNamespaces();
        spl_autoload_extensions(self::$classExtension);
        spl_autoload_register(array(new self(), 'classAutoLoad'));
    }

    /**
     * Recursively scans all 'libs' directories containing all needed classes
     *
     * @throws ClassLoader_Exception
     * @param $className
     *
     * @return void
     */
    public function classAutoLoad($className)
    {
        foreach (self::$ns as $classFileNs => $classFilePath) {

            print $classFileNs . ' ' . $classFilePath . '<br>';
            

            if ($classFileNs == $className) {
                $classFileName = $className . $this->getClassExtension();

                if (! is_readable($classFilePath)) {
                    throw new ClassLoaderMapperException(sprintf(' %s - [Error]: Unable to load file "%s" found in %s', get_class($this), $classFileName, $classFilePath));
                }

                require_once($classFilePath);

                if (! interface_exists($className, false) and ! class_exists($className, false)) {
                    throw new ClassLoaderMapperException(sprintf('No Interface or Class "%s" found in file %s', $className, $classFilePath));
                }

                self::setLoadedClassFile($classFileNs, $filePath);
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
        self::$classExtension .= trim($extension);
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

    /**
     * Returns an array classes loaded
     *
     * @static
     * @return array An array of classes loaded
     */
    public static function getLoadedClassFile()
    {
        return self::$loadedClass;
    }


}
