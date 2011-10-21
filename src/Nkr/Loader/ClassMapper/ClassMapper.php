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
 * @subpackage  ClassMapper
 * @author      nuukeet <nuukeet@gmail.com>
 * @copyright	Copyright (c) 2011 nk-reloaded project
 * @link	https://github.com/nuukeet/nk-reloaded
 * @version	$Id: $
 */
/**
 * @package     Nuukeet
 * @subpackage  ClassMapper
 * @author      nuukeet <nuukeet@gmail.com>
 * @copyright	Copyright (c) 2011 nk-reloaded project
 */

final class ClassMapper
{
    /**
     * An array of namespaces
     *
     * @var array namespaces
     */
    protected static $namespaces = array(
        'Config' => 'src/Nkr/Config/Config.php'
    );

    /**
     * ClassMapper instance
     *
     * @var ClassMapper
     */
    protected static $instance = null;




    
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
     * Returns current ClassMapper instance
     *
     * @return ClassMapper
     */
    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Returns all namespaces
     *
     * @return array An array of namespaces
     */
    public static function getNamespaces()
    {
        return self::$namespaces;
    }

    /**
     * Adds a new namespaces array
     *
     * @return void
     */
    public static function addNamespaces(array $ns)
    {
        foreach ($ns as $key => $value) {
            self::$namespaces[$key] = $value;
        }

        return;
    }
}