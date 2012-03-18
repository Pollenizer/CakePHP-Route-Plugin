# CakePHP Route Plugin

A CakePHP Plugin for handling all your database-driven routing needs.

## Installation

-   Copy the plugin to ``app/Plugin/Route``
-   Execute the schema generation SQL in ``app/Plugin/Route/Config/Schema/db_route.sql``

    CREATE TABLE `routes` (
     `id` INT(10) NOT NULL AUTO_INCREMENT,
     `name` VARCHAR(255) NOT NULL,
     `value` VARCHAR(255) NOT NULL,
     `key` CHAR(40) NOT NULL,
     PRIMARY KEY (`id`),
     KEY `name` (`name`),
     KEY `value` (`value`),
     UNIQUE KEY `key` (`key`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-   Enable the plugin in ``app/Config/bootstrap.php``

## Configuration

### Automatically creating routes Using the Routable Behavior

Attach the Routable Behavior to the models for which you want to create routes

    public $actsAs = array(
        'Route.Routable' => array(
            'template' => 'posts/:title'
        )
    );

The ``template`` setting tells the behavior how to format the route. For example, in the above example, if a new post is created with a ``title`` of "A Tale of Two Cities", the resulting route would be ``posts/a-tale-of-two-cities``

### Enabling the custom route class

Enable the ``ModelRoute`` custom route class in ``app/Config/routes.php``

    App::import('Route.Lib', 'ModelRoute');
    Router::connect('/',
        array(
            'controller' => 'pages',
            'action' => 'display',
            'home'
        ),
        array(
            'routeClass' => 'ModelRoute'
        )
    );
