## Redmine API Client

### Installation

`composer require mcmatters/redmine-api`

### Usage

```php
<?php

require 'vendor/autoload.php';

$client = new \McMatters\RedmineApi\RedmineClient('https://redmine.org', 'API_KEY');

$issue = $client->issue()->create([
    'project_id' => 1,
    'subject' => 'Foo',
    'description' => 'bar',
]);

$client->timeEntry()->create($issue['id'], '15min');
```
