# Pixela [![Build Status](https://travis-ci.org/tsmsogn/Pixela.svg?branch=master)](https://travis-ci.org/tsmsogn/Pixela) [![codecov](https://codecov.io/gh/tsmsogn/Pixela/branch/master/graph/badge.svg)](https://codecov.io/gh/tsmsogn/Pixela) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/tsmsogn/Pixela/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/tsmsogn/Pixela/?branch=master)

Pixela client for PHP

## Usage

### Client

```php
<?php
$client = new \Pixela\Client('tsmsogn-ghost', 'thisissecret');
```

### User

```php
<?php
$user = $client->api('User');

// Create user
$user->create();
        
// Update user
$updated = $user->update('thisisnewsecret');

// Delete user
$user->delete();
```

### Graphs

```php
<?php
$graph = $this->client->api('Graphs');

// Create graph
$graph->setId('test-graph')
    ->setName('graph-name')
    ->setUnit('commit')
    ->setType('int')
   ->setColor('shibafu');
$graph->create();

// Get graphs
$graphs = $graph->get();

// Get SVG
$graph->getSVG()

// Update graph
$graph->setName('new-test-graph')
    ->setUnit('calory')
    ->setColor('momiji')
    ->setTimezone('UTC')
    ->setPurgeCacheURLs(array(
        'https://camo.githubusercontent.com/xxx/xxxx'
    ));
$graph->update();

// Delete graph
$this->assertTrue($graph->delete());

// Get URL
$graph->getURL();
```

### Pixel

```
<?php
$pixel = $this->client->api('Pixel');

// Create pixel
$pixel->setGraphID('test-graph')
    ->setDatetime(new \DateTime())
    ->setQuantity(1);
$pixel->post();

// Get pixel
$pixel->get();

// Update pixel
$pixel->setQuantity(10)
    ->setOptionalData(json_encode('foo'));
$pixel->update();

// Increment pixel
$pixel->increment();

// Decrement pixel
$pixel->decrement();

// Delete pixel
$pixel->delete();
```

### Webhooks

```php
<?php
$webhook = $this->client->api('Webhooks');

// Create webhook
$webhook->setGraphID('test-graph')
    ->setType('increment');
$webhook->create();

// Get webhooks
$webhook->get();

// Invoke webhook
$webhook->invoke();

// Delete webhook
$webhook->delete();
```
