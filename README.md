## Fifty & Fifty Frame Work Portfolio Plugin
==========

Show your work on your site


### Features

Quickly change the slug with

```php
if( !defined('FFW_STAFF_SLUG') ){
	define( 'FFW_STAFF_SLUG', 'work' );
}
```

or quickly change the labels with

```php
function ffw_port_labels( $labels ) {
	$labels = array(
	   'singular' => __('Work', 'your-domain'),
	   'plural' => __('Work', 'your-domain')
	);
	return $labels;
}
add_filter('ffw_port_default_name', 'ffw_port_labels');
```


### Changelog

Coming soon.