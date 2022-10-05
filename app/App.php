<?php

namespace App;

use App\Exceptions\PageNotFoundException;
use App\Services\ArticleService;
use App\Contracts\{DatabaseInterface,
    RenderInterface,
    RequestInterface,
    Services\ArticleServiceInterface,
    Services\UserServiceInterface
};
use App\Enums\Env;
use App\Exceptions\RouteNotFoundException;
use App\Services\UserService;
use Dotenv\Dotenv;
use Illuminate\Container\Container;
use Psr\Container\{ContainerExceptionInterface, NotFoundExceptionInterface};
use Twig\Loader\FilesystemLoader;
use Twig\Extra\Intl\IntlExtension;

class App
{
    public function __construct(
        protected Container $container,
        protected ?Router $router = null,
        protected array $request = []
    ) {
    }

    public function boot(): static
    {
        session_start();

        //Env init.
        $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        $config = new Config($_ENV);

        //Error reporting settings
        $env = $config->env ?? Env::DEV;
        if ($env === Env::DEV) {
            ini_set('display_errors', '1');
            ini_set('display_startup_errors', '1');
            error_reporting(E_ALL);
        }

        //Twig init.
        $twig = new TemplateRenderer(
            new FilesystemLoader(VIEW_PATH),
            [
                'cache' => STORAGE_PATH . '/cache',
                'auto_reload' => true,
            ]
        );
        $twig->addExtension(new IntlExtension());
        $twig->addGlobal('is_logged_in', UserService::isLoggedIn());
        $this->container->bind(RenderInterface::class, fn() => $twig);

        //Database init.
        $this->container->bind(DatabaseInterface::class, function () use ($config) {
            return new Database(
                $config->db['host'],
                $config->db['dbname'],
                $config->db['user'],
                $config->db['password'],
                $config->db['charset']
            );
        });

        //Request init.
        $this->container->bind(RequestInterface::class, fn() => (new Request($_GET, $_POST, $_SERVER)));

        //User bindings.
        $this->container->bind(UserServiceInterface::class, UserService::class);
        $this->container->bind(ArticleServiceInterface::class, ArticleService::class);

        return $this;
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function run(): void
    {
        try {
            echo $this->router->resolve($this->request['uri'], $this->request['method']);
        } catch (RouteNotFoundException|PageNotFoundException) {
            http_response_code(404);
            echo $this->container->get(RenderInterface::class)->render('error/404.twig');
        }
    }
}
