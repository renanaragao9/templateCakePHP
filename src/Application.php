<?php

declare(strict_types=1);

namespace App;

use Cake\Core\Configure;
use Cake\Core\ContainerInterface;
use Cake\Datasource\FactoryLocator;
use Cake\Error\Middleware\ErrorHandlerMiddleware;
use Cake\Http\BaseApplication;
use Cake\Http\Middleware\BodyParserMiddleware;
use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Http\MiddlewareQueue;
use Cake\ORM\Locator\TableLocator;
use Cake\Routing\Middleware\AssetMiddleware;
use Cake\Routing\Middleware\RoutingMiddleware;
use App\Middleware\ApiKeyMiddleware;
use App\Event\PasswordResetObserver;

class Application extends BaseApplication
{
    public function bootstrap(): void
    {
        parent::bootstrap();

        if (PHP_SAPI === 'cli') {
            $this->bootstrapCli();
        } else {
            FactoryLocator::add(
                'Table',
                (new TableLocator())->allowFallbackClass(false)
            );
        }

        if (Configure::read('debug')) {
            $this->addPlugin('DebugKit');
        }

        $this->getEventManager()->on(new PasswordResetObserver());

        $this->addPlugin('CakeLte');
    }

    public function middleware(MiddlewareQueue $middlewareQueue): MiddlewareQueue
    {
        $csrf = new CsrfProtectionMiddleware([
            'httponly' => true,
        ]);

        // Adicione uma verificação para ignorar CSRF para rotas da API
        $csrf->skipCheckCallback(function ($request) {
            return $request->getParam('prefix') === 'Api';
        });

        $middlewareQueue
            ->add(new ErrorHandlerMiddleware(Configure::read('Error'), $this))
            ->add(new AssetMiddleware([
                'cacheTime' => Configure::read('Asset.cacheTime'),
            ]))
            ->add(new RoutingMiddleware($this))
            ->add(new BodyParserMiddleware())
            ->add($csrf);

        // Adicione o ApiKeyMiddleware somente se o prefixo for Api
        $middlewareQueue->add(function ($request, $handler) {
            if ($request->getParam('prefix') === 'Api') {
                return (new ApiKeyMiddleware())->process($request, $handler);
            }
            return $handler->handle($request);
        });

        return $middlewareQueue;
    }

    public function services(ContainerInterface $container): void {}

    protected function bootstrapCli(): void
    {
        $this->addOptionalPlugin('Bake');
        $this->addPlugin('Migrations');
    }
}
