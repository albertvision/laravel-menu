<?php
namespace YGeorgiev\Menu;

use Html;

class MenuItem {

    /**
     * Which properties to be included at the toArray() return.
     *
     * @var array
     */
    private $_fillable = [
        'url',
        'label',
        'attributes',
        'pattern',
        'children',
        'prefix'
    ];

    /**
     * @var string
     */
    private $_url;

    /**
     * @var string
     */
    private $_label;

    /**
     * @var array
     */
    private $_attributes;

    /**
     * @var string|null
     */
    private $_pattern = null;

    /** Children items of this item.
     *
     * @var null|MenuBuilder
     */
    private $_children = null;

    /**
     * Prefix of the URL
     *
     * @var string
     */
    private $_prefix = '';

    public function __construct($url, $label, $attributes = []) {
        $this->setUrl($url);
        $this->setLabel($label);
        $this->setAttribute(null, $attributes);
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    public function setAttribute($key, $value) {
        if($key === null) {
            $this->_attributes = $value;
        } else {
            $this->_attributes[$key] = $value;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl() {
        return $this->_url;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setUrl($value) {
        $this->_url = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getLabel() {
        return $this->_label;
    }

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setLabel($value) {
        $this->_label = $value;

        return $this;
    }

    /**
     * @param string|null $key
     *
     * @return array|mixed
     */
    public function getAttribute($key = null) {
        return $key !== null ? $this->_attributes[$key] : $this->_attributes;
    }

    /**
     * @return string|null
     */
    public function getPattern() {
        return $this->_pattern;
    }

    /**
     * Set item's URL pattern. It is used to select the active item.
     *
     * @param string $regex
     *
     * @return $this
     */
    public function setPattern($regex) {
        $this->_pattern = $regex;

        return $this;
    }

    /**
     * @return null|MenuBuilder
     */
    public function getChildren() {
        return $this->_children;
    }

    /**
     * @param \Closure $callback The first parameter is MenuBuilder.
     *
     * @return $this
     */
    public function setChildren(\Closure $callback) {
        $child = new MenuBuilder();
        $child->setPrefix($this->_prefix);
        $this->_children = $child;

        $callback($child);

        return $this;
    }

    /**
     * Checks has the item got any children.
     *
     * @return bool
     */
    public function hasChildren() {
        return (bool)count($this->_children);
    }

    /**
     * Returns the URL's prefix
     *
     * @return string
     */
    public function getPrefix() {
        return $this->_prefix;
    }

    /**
     * Set new prefix for the URL.
     *
     * @param string $value
     *
     * @return $this
     */
    public function setPrefix($value) {
        $this->_prefix = $value;

        return $this;
    }
}