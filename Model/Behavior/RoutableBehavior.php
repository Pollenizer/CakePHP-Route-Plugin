<?php
/**
 * Routable Behavior
 *
 * A CakePHP Model Behavior class for saving routes to a database table.
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
 * Routable Behavior
 */
class RoutableBehavior extends ModelBehavior
{
    /**
     * Route
     *
     * @var object
     */
    public $Route = null;

    /**
     * After Save
     *
     * @param object $Model An instance of the model attaching this behavior
     * @param boolean $created True if this save created a new record
     * @return void
     * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
     */
    public function afterSave(Model $Model, $created)
    {
        // Does the route template exist?
        if (empty($this->settings[$Model->alias]['template'])) {
            return;
        }

        // Define template parts
        $parts = explode('/', $this->settings[$Model->alias]['template']);

        // Build the route from the template
        foreach ($parts as $i => $part) {
            if (substr($part, 0, 1) == ':') {
                $field = str_replace(':', '', $part);
                if ($Model->isVirtualField($field)) {
                    $value = $Model->field($field, array($Model->alias . '.' . $Model->primaryKey => $Model->data[$Model->alias][$Model->primaryKey]));
                }
                else {
                    $value = $Model->data[$Model->alias][$field];
                }
                $value = substr($value, 0, 200);
                $value = strtolower($value);
                $value = Inflector::slug($value, '-');
                $parts[$i] = $value;
            }
        }

        // Define the route id (null for CREATE by default)
        $id = null;

        // Define the route name (friendly URL)
        $name = implode('/', $parts);

        // Define the route value (system URL)
        $value = $Model->table . '/view/' . $Model->id;

        // Instantiate Route model
        $this->Route = new Route();

        // Find the route by name
        $route = $this->Route->findByName($name);

        // If the route name already exists for another route value,
        // Ensure its uniqueness
        if (!empty($route) && $route['Route']['value']!=$value) {
            $routeName = $name;
            $unique = false;
            $i = 1;
            while (!$unique) {
                $routeName = $name . '-' . $i;
                $route = $this->Route->findByName($routeName);
                if (empty($route)) {
                    $unique = true;
                }
                $i++;
            }
            $name = $routeName;
        }

        // Find the route by value
        $route = $this->Route->findByValue($value);

        // If the route value already exists,
        // set the id so an UPDATE occurs
        if (!empty($route)) {
            $id = (int) $route['Route']['id'];
        }

        // Save the route
        $this->Route->save(array(
            'id' => $id,
            'name' => $name,
            'value' => $value
        ));
    }

    /**
     * Setup
     *
     * @param object $Model An instance of the model attaching this behavior
     * @param array $settings The settings being passed to the behavior
     * @return void
     * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
     */
    public function setup(Model $Model, $settings = array())
    {
        $this->settings[$Model->alias] = $settings;
    }
}
