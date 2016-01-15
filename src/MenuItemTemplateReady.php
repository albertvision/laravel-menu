<?php
namespace YGeorgiev\Menu;

use Html;
use Request;

class MenuItemTemplateReady {
    /**
     * @var MenuItem
     */
    private $_item;

    /**
     * @param MenuItem $item
     */
    public function __construct(MenuItem $item) {
        $this->_item = $item;
    }

    /**
     * Checks has the item got any children.
     *
     * @return bool
     */
    public function hasChildren() {
        return (bool) count($this->_item->getChildren());
    }

    /**
     * Returns the URL of the item.
     *
     * @param bool $returnAsAbsolute. If the value is [true], then will be returned an absolute URL.
     *
     * @return string
     */
    public function getUrl($returnAsAbsolute = true) {
        $url = $this->_item->getPrefix().$this->_item->getUrl();

        if($returnAsAbsolute === false) {
            $url = preg_replace('/\/{2,}/', '/', $url);

            if(substr($url, 0, 1) == '/') {
                $url = substr($url, 1);
            }
            if(substr($url, -1) == '/') {
                $url = substr($url, 0, strlen($url)-1);
            }
        }

        return $returnAsAbsolute ? url($url) : $url;
    }

    /**
     * Returns a single attribute.
     *
     * @param string $key Key of the attribute.
     * @param null|string $default Default value if an attribute with the provided key is not found.
     *
     * @return mixed
     */
    public function getAttribute($key, $default = null) {
        $attribute = $this->_item->getAttribute($key);

        return $attribute !== null ? $attribute : $default;
    }

    public function getAttributes($mergeAttributes = []) {
        $attributes = $this->_item->getAttribute();
        $attributes['href'] = $this->getUrl();

        return Html::attributes(array_merge($attributes, $mergeAttributes));
    }

    /**
     * Returns the URL's label.
     *
     * @return string
     */
    public function getLabel() {
        return $this->_item->getLabel();
    }

    /**
     * Checks is the current item active.
     *
     * @return bool
     */
    public function isActive() {
        return Request::is($this->getUrl(false));
    }

    /**
     * Returns the children of the item.
     *
     * @return array|null
     */
    public function getChildren() {
        return $this->_item->getChildren()->toArray();
    }
}