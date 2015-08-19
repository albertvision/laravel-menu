<?php
namespace YGeorgiev\Menu;

use Illuminate\Contracts\Support\Arrayable;

class MenuBuilder implements Arrayable {
    /**
     * Items at this menu builder
     * @var array
     */
    private $_items = [];

    /**
     * Prefix for the URL.
     *
     * @var string
     */
    private $_prefix = '';

    /**
     * Items which will be appended to the URL's prefix.
     *
     * @var array
     */
    private $_appendToPrefix = [];

    /**
     * Add new item.
     *
     * @param string $url
     * @param string $label
     * @param array $attributes
     *
     * @return MenuItem
     */
    public function addItem($url, $label, $attributes = []) {
        $item = new MenuItem($url, $label, $attributes);
        $item->setPrefix($this->_prefix);

        $this->_items[] = $item;

        return $item;
    }

    /**
     * Set a new prefix for the URL.
     * @param string $value
     *
     * @return $this
     */
    public function setPrefix($value) {
        $this->_prefix = $value;

        return $this;
    }

    /**
     * Append value to the URL's prefix.
     * @param string $value
     *
     * @return $this
     */
    public function appendPrefix($value) {
        $this->_appendToPrefix[] = $value;

        return $this;
    }

    /**
     * Applies the prefix for the all URLs.
     */
    private function _applyPrefix() {
        $newPrefix = $this->_prefix.implode('', $this->_appendToPrefix);

        foreach($this->_items as $key => $item) {
            $this->_items[$key] = $item->setPrefix($newPrefix);
        }
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray() {
        $data = [];

        $this->_applyPrefix();

        foreach($this->_items as $item) {
            $data[] = new MenuItemTemplateReady($item);
        }

        return $data;
    }
}