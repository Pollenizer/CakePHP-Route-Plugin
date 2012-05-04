<?php
/**
 * Model Route
 *
 * A CakePHP Lib class for forward and reverse routing of routes accessible via
 * a model. For example, routes stored in a database table.
 *
 * PHP 5
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the below copyright notice.
 *
 * @author     Robert Love <robert@pollenizer.com>
 * @copyright  Copyright 2012, Pollenizer Pty. Ltd. (http://pollenizer.com)
 * @license    MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @since      CakePHP(tm) v 2.1.0
 */

App::uses('Route', 'Route.Model');

/**
 * Model Route
 *
 */
class ModelRoute extends CakeRoute
{
    /**
     * Route
     *
     * @var object
     */
    public $Route = null;

    /**
     * Construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->Route = new Route();
    }

    /**
     * Match
     *
     * @param array $url An array of parameters to check matching with
     * @return mixed Either a string url for the parameters if they match or false
     * @link http://api20.cakephp.org/class/cake-route#method-CakeRoutematch
     */
    public function match($url)
    {
        if (empty($url)) {
            return false;
        }
        $params = array(
            $url['plugin'],
            $url['controller'],
            $url['action']
        );
        unset($url['plugin']);
        unset($url['controller']);
        unset($url['action']);
        ksort($url, SORT_NUMERIC);
        foreach ($url as $val) {
            $params[] = $val;
        }
        $routeName = $this->Route->field('name', array(
            'Route.value' => implode('/', array_filter($params))
        ));
        if (empty($routeName)) {
            return false;
        }
        return $routeName;
    }

    /**
     * Parse
     *
     * @param string $url The url to attempt to parse
     * @return mixed Boolean false on failure, otherwise an array of parameters
     * @link http://api20.cakephp.org/class/cake-route#method-CakeRouteparse
     */
    public function parse($url)
    {
        $parts = array_filter(explode('/', $url));
        $url = implode('/', $parts);
        $routeValue = $this->Route->field('value', array(
            'Route.name' => $url
        ));
        if (empty($routeValue)) {
            return false;
        }
        $parts = explode('/', $routeValue);
        $count = count($parts);
        if ($count >= 2) {
            $params['controller'] = $parts[0];
            $params['action'] = $parts[1];
            $params['plugin'] = null;
            $params['pass'] = $params['named'] = array();
            for ($i = 2; $i < $count; $i++) {
                $params['pass'][] = $parts[$i];
            }
            return $params;
        }
        return false;
    }
}
