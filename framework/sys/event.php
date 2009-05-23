<?php

/* (C) 2009 Netology Joy Web Framework, All rights reserved.
 *
 * Author(s):
 *   Hasan Ozgan (meddah@netology.org)
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class joy_Event 
{
    private $values;
    private static $instance;
  
    static function &getInstance()
    {
        if (!is_object(self::$instance)) {
            self::$instance = new joy_Event();
        }

        return self::$instance;
    }

    public function Register($name, $method, $class)
    {
        $this->values[$name][] = array("class"=>$class, "method"=>$method);
    }

    public function UnRegister($name, $method, $class)
    {
    }

    public function Dispatch($name, $object=null, $args=null)
    {
        if (empty($this->values[$name]) == false) 
        {
            foreach ($this->values[$name] as $item) 
            {
                $ref = new ReflectionClass($item["class"]);
                $ref->getMethod($item["method"])->invoke($item["class"], &$object, &$args);
            }
        }
    }
}

?>
