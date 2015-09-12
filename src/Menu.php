<?php
namespace YGeorgiev\Menu;
use Illuminate\Contracts\View\Factory as ViewFactory;

/**
 * Class Menu
 *
 * @package YGeorgiev\Menu
 */
class Menu {

    /**
     * Laravel's View Service
     *
     * @var View
     */
    protected $views;

    /**
     * @var array
     */
    private $_menus = [];

    public function __construct(ViewFactory $view) {
        $this->views = $view;
    }

    /**
     * Create a new menu.
     *
     * @param $name Key of the menu. You will use it when you want to retrieve the menu later.
     * @param \Closure $callback
     *
     * @return $this
     * @throws \Exception Menu item is already taken.
     */
    public function create($name, \Closure $callback) {
        if(isset($this->_menus[$name])) {
            throw new \Exception('Menu name ['.$name.'] is already taken.');
        }

        $this->_menus[$name] = new MenuBuilder();

        $callback($this->_menus[$name]);

        return $this;
    }

    /**
     * Returns the HTML of a menu.
     *
     * @param string $name Key of the menu you want to retrieve.
     * @param string $view Which view will be loaded.
     *
     * @return \Illuminate\View\View
     */
    public function get($name, $view = 'menu::default') {
        if(!$this->_menus[$name]) {
            throw new \BadMethodCallException('Invalid menu name ['.$name.']');
        }

        $data = $this->_menus[$name];

        return view($view, [
            'items' => $data->toArray()
        ]);
    }
}