<?php
/**
 * Route Model
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

App::uses('RouteAppModel', 'Route.Model');

/**
 * Route Model
 *
 */
class Route extends RouteAppModel
{
    /**
     * Validate
     *
     * @var array
     */
    public $validate = array(
        'name' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter a route name. This is the "friendly" URL. For example: a-tale-of-two-cities',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
        'value' => array(
            'notEmpty' => array(
                'rule' => array('notEmpty'),
                'message' => 'Please enter a route value. This is the "system" URL. For example: posts/view/123',
                'allowEmpty' => false,
                'required' => true,
            ),
        ),
    );
}
