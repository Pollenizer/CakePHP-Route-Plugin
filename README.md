# CakePHP Route Plugin

A CakePHP Plugin for handling all your database-driven routing needs.

## Installation

1.   Copy the plugin to ``app/Plugin/Route``
1.   Create the ``routes`` table by executing the schema generation SQL in ``app/Plugin/Route/Config/Schema/db_route.sql``
1.   Enable the plugin in ``app/Config/bootstrap.php``

    CakePlugin::loadAll(array(
        'Route' => array(
            'routes' => true
        )
    ));

## Usage

### Automatically creating routes using the ``RoutableBehavior``

Attach the Routable Behavior to the models for which you want to automatically create routes.

    public $actsAs = array(
        'Route.Routable' => array(
            'template' => 'posts/:title'
        )
    );

The ``template`` setting tells the behavior how to format the route. In the above example, if a new post is created with a ``title`` of "A Tale of Two Cities", the resulting route would be ``posts/a-tale-of-two-cities``
