# CakePHP Route Plugin

A CakePHP Plugin for handling all your database-driven routing needs.

Many applications have the need to use "friendly" URLs like ``example.com/posts/a-tale-of-two-cities`` instead of the default "system" URLs like ``example.com/posts/view/123``. Many developers have tended towards storing a ``slug`` field in the table itself. For example:

<table>
    <thead>
        <tr>
            <th>id</th>
            <th>title</th>
            <th>body</th>
            <th>slug</th>
            <th>created</th>
            <th>modified</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>123</td>
            <td>A Tale of Two Cities</td>
            <td>It was the best of times, it was the worst of times...</td>
            <td>a-tale-of-two-cities</td>
            <td>1859-04-30 09:00:00</td>
            <td>1859-11-26 09:00:00</td>
        </tr>
    </tbody>
</table>

The problem with this approach is that the friendly URL is intrinsically tied to the model. What happens if you then want friendly URLs for Users, or Tags, or anything else? The answer is you'll need to add ``slug`` fields to all these models and adjust your routes configuration accordingly.

The CakePHP Route Plugin abstracts this functionality by providing a handy collection of classes to automate the creation, storage and use of custom routes. It lets you create links the "Cake" way:

<pre>$this->Html->link($post['Post']['title'], array(
    'controller' => 'posts',
    'action' => 'view',
    $post['Post']['id']
));</pre>

Sitting quietly and cleverly off to the side whilst it automatically handles both forward and reverse routing of your URLs.

## Installation

1.   Copy the plugin to ``app/Plugin/Route``
1.   Create the ``routes`` table by executing the schema generation SQL in ``app/Plugin/Route/Config/Schema/db_route.sql``
1.   Enable the plugin in ``app/Config/bootstrap.php``

<pre>CakePlugin::loadAll(array(
    'Route' => array(
        'routes' => true
    )
));</pre>

## Usage

### Automatically creating routes using the ``RoutableBehavior``

Attach the Routable Behavior to the models for which you want to automatically create routes.

<pre>public $actsAs = array(
    'Route.Routable' => array(
        'template' => 'posts/:title'
    )
);</pre>

The ``template`` setting tells the behavior how to format the route. In the above example, if a new post is created with a ``title`` of "A Tale of Two Cities", the resulting route would be ``posts/a-tale-of-two-cities``
