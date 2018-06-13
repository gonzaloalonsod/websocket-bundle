# Simple Symfony 4 websocket bundle

This small bundle is a Ratchet abstraction for Symfony 4. Just create message handlers and your server is set.

## Installation

Open a command console, enter your project directory and execute:

```console
$ composer require rollandrock/websocket-bundle
```

## Create handlers

Create services implementing `HandlerInterface`:

```php
<?php

// src/Handler/WelcomeHandler.php
namespace App\Handler;

use Ratchet\ConnectionInterface;
use RollandRock\WebsocketBundle\Client\ClientStack;
use RollandRock\WebsocketBundle\Handler\HandlerInterface;

class WelcomeHandler implements HandlerInterface
{
    public static function getName(): string
    {
        return 'welcome';
    }

    public function handle(ClientStack $clientStack, ConnectionInterface $from, array $data)
    {
        // Handle the "welcome" message sent by $from, containing $data.
        // You also have access to the whole clients stack
    }
}
```

## Configure handlers

The default port is 4242. You can change it.
Also, the default clients that will be provided will be instances of `RollandRock\WebsocketBundle\Client`. You can extend it to fit your needs and specify it in the config.

```yaml
rolland_rock_websocket:
    port: 3240
    client: App\Client\Client
```

## Run the server

```bash
    php bin/console rr:websocket:server
```

## Send messages

The messages need to have the following format :

```json
    {
      "type": "welcome",
      "data": {
        /* some data */
      }
    }
```
