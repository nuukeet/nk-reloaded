<?php

class nkrLoader
{
    /**
     * An array of classes
     * 
     * @var array
     */
    protected static $classes = array();
    
    /**
     * nkrLoader instance
     * 
     * @var nkrLoader
     */
    private static $loader;
    
    
    /**
     *
     * @return type 
     */
    private function __construct()
    {
        if (function_exists('__autoload')) {
            spl_autoload_register('__autoload');
        }

        return spl_autoload_register(array($this, 'classAutoLoad'));
    }
    
    /**
     * Initialize the loader ( Singleton )
     * 
     * @return nkrLoader 
     */
    public static function init()
    {
        if (null === self::$loader) {
            self::$loader = new self();
        }
        
        return self::$loader;
    }
    
    
    
    private function classAutoLoad($className) 
    {
        
    }
    
    
    protected function getLoadedClasses()
    {
        return self::$classes;
    }
    
    
    
}