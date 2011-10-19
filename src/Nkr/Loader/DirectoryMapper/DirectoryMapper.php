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
 * @subpackage  DirectoryMapper
 * @author      nuukeet <nuukeet@gmail.com>
 * @copyright	Copyright (c) 2011 nk-reloaded project 
 * @link	https://github.com/nuukeet/nk-reloaded
 * @version	$Id: $
 */
/**
 * @package     Nuukeet
 * @subpackage  DirectoryMapper
 * @author      nuukeet <nuukeet@gmail.com>
 * @copyright	Copyright (c) 2011 nk-reloaded project 
 */

class DirectoryMapper
{
    /**
     * An array of directories
     * 
     * @var array
     */
    protected $directories = array();
    
    
    
    
    
    /**
     * Sets directory where all classes file to load are stored
     * 
     * @param type $directory 
     * 
     * @return DirectoryMapper instance
     */
    public function setDirectory($directory)
    {
        $this->directories[$directory] = $directory;
        
        return $this;
    }
    
    /**
     * Returns all directories
     * 
     * @return array An array of directories
     */
    public static function getDirectories()
    {
       return $this->directories; 
    }
    
    /**
     * Added an array of directories
     * 
     * @param array $directories An array of directories
     * 
     * @return DirectoryMapper instance
     */
    public static function addDirectories(array $directories = array())
    {
        foreach($directories as $directory) {
            $this->setDirectory($directory);
        }
        
        return $this;
    }   
    
    /**
     * 
     */
    public static function getClassFiles()
    {
        
    }
}