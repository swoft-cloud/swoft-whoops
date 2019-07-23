# Swoft Whoops

Swoft http errors for cool kids by [filp/whoops](https://github.com/filp/whoops)

## Install

- composer command

```bash
composer require --dev swoft/whoops
```

## Usage

```php
<?php declare(strict_types=1);

namespace App\Exception\Handler;

use ReflectionException;
use Swoft\Bean\Exception\ContainerException;
use Swoft\Error\Annotation\Mapping\ExceptionHandler;
use Swoft\Http\Message\Response;
use Swoft\Http\Server\Exception\Handler\AbstractHttpErrorHandler;
use Swoft\Log\Helper\CLog;
use Swoft\Whoops\WhoopsHandler;
use Throwable;
use function bean;
use function context;
use const APP_DEBUG;

/**
 * Class HttpExceptionHandler
 *
 * @ExceptionHandler(\Throwable::class)
 */
class HttpExceptionHandler extends AbstractHttpErrorHandler
{
    /**
     * @param Throwable $e
     * @param Response  $response
     *
     * @return Response
     * @throws ReflectionException
     * @throws ContainerException
     */
    public function handle(Throwable $e, Response $response): Response
    {
        $request = context()->getRequest();
        if ($request->getUriPath() === '/favicon.ico') {
            return $response->withStatus(404);
        }

        // Log
        CLog::error($e->getMessage());

        // Debug is false
        if (!APP_DEBUG) {
            return $response
                ->withStatus(500)
                ->withContent($e->getMessage());
        }

        // Debug is true
        $whoops  = bean(WhoopsHandler::class);
        $content = $whoops->run($e, $request);

        return $response->withContent($content);
    }
}
```

## LICENSE

The Component is open-sourced software licensed under the [Apache license](LICENSE).
