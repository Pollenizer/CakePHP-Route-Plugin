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
        if (!empty($this->settings[$Model->alias]['template'])) {
            $parts = explode('/', $this->settings[$Model->alias]['template']);
            foreach ($parts as $i => $part) {
                if (substr($part, 0, 1) == ':') {
                    $field = str_replace(':', '', $part);
                    $value = substr($Model->data[$Model->alias][$field], 0, 200);
                    $value = strtolower($value);
                    $value = Inflector::slug($value, '-');
                    $parts[$i] = $value;
                }
            }
            $name = implode('/', $parts);
            $value = $Model->table . '/view/' . $Model->id;
            $this->Route = new Route();
            $this->Route->save(array(
                'name' => $name,
                'value' => $value
            ));
        }
    }

    /**
     * Setup
     *
     * @param object $Model An instance of the model attaching this behavior
     * @param array $settings The settings being passed to the behavior
     * @return void
     * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#aftersave
     */
    public function setup(Model $Model, $settings)
    {
        $this->settings[$Model->alias] = $settings;
    }
}
