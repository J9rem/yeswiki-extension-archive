<?php
/*
 * This file is part of the YesWiki Extension archive.
 *
 * Authors : see README.md file that was distributed with this source code.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YesWiki\Archive\Entity;

use ArrayAccess;
use Countable;
use Iterator;
use YesWiki\Archive\Service\ConfigurationService;

class ConfigurationFile implements ArrayAccess, Iterator, Countable
{
    private $_file = "";
    protected $_parameters;
    protected $configurationService;

    /**
     * @param $file 
     * @param ConfigurationService|null $configurationService
     */
    public function __construct($file,?ConfigurationService $configurationService = null)
    {
        $this->_file = $file;
        $this->_parameters = [];
        if ($configurationService instanceof ConfigurationService){
            $this->configurationService = $configurationService;
        } elseif (isset($GLOBALS["wiki"])) {
            $this->configurationService = $GLOBALS["wiki"]->services->get(ConfigurationService::class);
        }
    }

    public function __get($name)
    {
        if ($name == "_file") {
            return $this->_file;
        } elseif ($name == "_parameters") {
            return $this->_parameters;
        }
        if (isset($this->_parameters[$name])) {
            return $this->_parameters[$name];
        }
        throw new \Exception("Paramètre inconnu Configuration::$name", 1);
    }

    public function __isset($name)
    {
        return isset($this->_parameters[$name]);
    }

    public function __set($name, $value)
    {
        if ($name != "_file") {
            $this->_parameters[$name] = $value;
        }
    }

    public function __unset($name)
    {
        unset($this->_parameters[$name]);
    }

    public function load($arrayName = "wakkaConfig")
    {
        if (!is_file($this->_file)) {
            return;
        }

        require $this->_file;

        if (isset($$arrayName)) {
            $this->_parameters = $$arrayName;
        }
    }

    /**
     * écrit le fichier de configuration
     * @param string|null $file
     * @param string $arrayName
     * @return bool
     */
    public function write($file = null, $arrayName = "wakkaConfig")
    {
        return $this->configurationService->write($this,$file, $arrayName);
    }

    /***************************************************************************
     * ArrayAccess
     **************************************************************************/
    #[\ReturnTypeWillChange]
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->_parameters[] = $value;
            return;
        }
        $this->_parameters[$offset] = $value;
    }

    #[\ReturnTypeWillChange]
    public function offsetExists($offset)
    {
        return isset($this->_parameters[$offset]);
    }

    #[\ReturnTypeWillChange]
    public function offsetUnset($offset)
    {
        unset($this->_parameters[$offset]);
    }

    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return isset($this->_parameters[$offset]) ? $this->_parameters[$offset] : null;
    }

    /***************************************************************************
     * Iterator
     **************************************************************************/
    #[\ReturnTypeWillChange]
    public function rewind()
    {
        return reset($this->_parameters);
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        return current($this->_parameters);
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        return key($this->_parameters);
    }

    #[\ReturnTypeWillChange]
    public function valid()
    {
        return isset($this->_parameters[$this->key()]);
    }

    #[\ReturnTypeWillChange]
    public function next()
    {
        return next($this->_parameters);
    }

    /*************************************************************************
     * Countable
     ************************************************************************/
    #[\ReturnTypeWillChange]
    public function count()
    {
        return count($this->_parameters);
    }
}
