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
 * @subpackage  nkrClassFileMapper
 * @author      nuukeet <nuukeet@gmail.com>
 * @copyright	Copyright (c) 2011 nk-reloaded project 
 * @link	https://github.com/nuukeet/nk-reloaded
 * @version	$Id: $
 */
/**
 * @package     Nuukeet
 * @subpackage  nkrClassFileMapper
 * @author      nuukeet <nuukeet@gmail.com>
 * @copyright	Copyright (c) 2011 nk-reloaded project 
 */

class nkrDirectoryMapper
{
    /**
     *
     * @var type 
     */
    protected static $directories = array();
    
    
    
    
    /**
     *
     * @param type $directory 
     */
    public static function setDirectory($directory)
    {
        self::$directories[$directory] = $directory;
    }
    
    /**
     * 
     */
    public static function getDirectories()
    {
       return self::$directories; 
    }
    
    /**
     *
     * @param array $directories 
     */
    public static function addDirectories(array $directories = array())
    {
        foreach($directories as $directory) {
            self::setDirectory($directory);
        }
    }   
    
    /**
     * 
     */
    public static function getClassFiles()
    {
        
    }
}