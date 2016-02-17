<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog;

use Exception;
use Nekudo\ShinyBlog\Action\Article;
use Nekudo\ShinyBlog\Action\Home;
use RuntimeException;
use FastRoute;
use FastRoute\RouteCollector;
use Nekudo\ShinyBlog\Responder\HttpResponder;

class ShinyBlog
{
    /** @var array $config */
    protected $config;

    /** @var FastRoute\Dispatcher $dispatcher */
    protected $dispatcher;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * ShinyBlog main method.
     * Dispatches and handles requests.
     */
    public function run()
    {
        try {
            $this->setRoutes();
            $this->dispatch();
        } catch(Exception $e) {
            // @todo throw some kind of error 500...
        }
    }

    /**
     * Defines blog and page routes.
     *
     * @throws RuntimeException
     */
    protected function setRoutes()
    {
        if (empty($this->config['routes'])) {
            throw new RuntimeException('No routes defined in configuration file.');
        }
        $this->dispatcher = FastRoute\simpleDispatcher(function(RouteCollector $r) {
            foreach ($this->config['routes'] as $routeName => $route) {
                if (empty($route['method']) || empty($route['route']) || empty($route['action'])) {
                    throw new RuntimeException('Invalid route in configuration.');
                }
                $r->addRoute($route['method'], $route['route'], $route['action']);
            }
        });
    }

    /**
     * Tries to find a route matching the current request. If found the defined action is called.
     */
    protected function dispatch()
    {
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);
        if (!isset($routeInfo[0])) {
            throw new RuntimeException('Could not dispatch request.');
        }
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                $responder = new HttpResponder;
                $responder->notFound();
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $responder = new HttpResponder;
                $responder->methodNotAllowed();
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $arguments = $routeInfo[2];
                $this->runAction($handler, $arguments);
                break;
            default:
                throw new RuntimeException('Could not dispatch request.');
        }
    }

    /**
     * Calls an action.
     *
     * @param string $actionName
     * @param array $arguments
     */
    protected function runAction(string $actionName, array $arguments = [])
    {
        switch ($actionName) {
            case 'home':
                $action = new Home;
                break;
            case 'article':
                $action = new Article;
                break;
            default:
                throw new RuntimeException('Invalid action.');
                break;
        }
        $action->__invoke($arguments);
    }
}
