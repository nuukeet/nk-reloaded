<?php 
/**
 * 
 */
abstract class nkrConfig 
{
    /**
     * An array of paramters
     * 
     * @var array An array of parameters
     */
    protected static $parameters = array();
    
    
    
    
    
    /**
     * Sets a new parameter
     * 
     * @param string $name The parameter's name
     * @param mixed $value The parameter's value
     * 
     * @return void
     */
    public function set($name, $value = null)
    {
        if (! isset(self::$parameters[$name])) {
            self::$parameters[$name] = $value;
        }
        
        return;
    }
    
    /**
     * Returns a parameter's value
     * 
     * @param string $name The parameter's name
     * 
     * @return mixed Returns null if the parameter's name does not exist
     */
    public function get($name)
    {
        if (isset(self::$parameters[$name])) {
            return self::$parameters[$name];
        }
        
        return null;
    }
    
    /**
     * Updated a paramater's value
     * 
     * @param string $name The parameter's name
     * @param mixed $value The parameter's value
     * 
     * @return void
     */
    public function update($name, $value = null)
    {
        if (isset(self::$parameters[$name])) {
            self::$parameters[$name] = $value;
        }
        
        return null;
    }
    
    /**
     * Checks if the parameter's name exists
     * 
     * @param string $name
     * 
     * @return boolean Returns true if the key exists 
     */
    public function has($name)
    {
        return array_key_exists($name, self::$parameters);
    }
    
    /**
     * Added an array of parameters to the current array
     * 
     * @param array $parameters An array of parameters
     * 
     * @return void 
     */
    public function add(array $parameters)
    {
        foreach ($parameters as $name => $value) {
            $this->set($name, $value);
        }
        
        return;
    }
    
    /**
     * Deletes a key from the current parameter array
     * 
     * @param string $name The key name to remove
     * 
     * @return void
     */
    public function remove($name)
    {
        unset(self::$parameters[$name]);
        
        return;
    }
    
    /**
     * Returns the parameter array
     * 
     * @return array An array of parameters
     */
    public function all()
    {
        return self::$parameters;
    }   
}