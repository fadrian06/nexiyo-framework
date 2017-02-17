<?php

/**
 * Nexiyo core loader
 */

namespace Nexiyo;

use \Dotenv\Dotenv;
use \Composer\Autoload\ClassLoader;
use \Illuminate\Database\Capsule\Manager as Capsule;
use \Twig_Loader_Filesystem;
use \Twig_Environment;

class Core
{
    protected static $instance = null;

    public $capsule, $twig_loader, $twig;
    protected $config = [];

    public static function init()
    {
        if (! isset(static::$instance)) static::$instance = new static;

        return static::$instance;
    }

    protected function __construct()
    {
        $this->loadEnv();
        $this->loadClasses();
        $this->connectDatabase();
        $this->updateFlight();
        $this->loadTwig();
    }

    protected function __clone() {}

    public static function start()
    {
        return \Flight::start();
    }

    public function getConfig($name)
    {
        // Get config file if it hasn't already been used. If it has, just return it.
        if (! isset($this->config[$name])) $this->config[$name] = include_once APP_DIR . '/config/' . $name . '.php';

        return $this->config[$name];
    }

    protected function loadEnv()
    {
        // Load our environment using Dotenv.
        $dotenv = new Dotenv(ROOT_DIR);
        $dotenv->load();
        $dotenv->required(['BASE_URL', 'DB_NAME', 'DB_PREFIX', 'DB_HOST', 'DB_USER', 'DB_PASS', 'DB_PORT']);
    }

    protected function loadClasses()
    {
        // Autoloading.
        $loader = new ClassLoader();
        $loader_conf = $this->getConfig('classes');

        foreach ($loader_conf['psr0'] as $ns => $paths) $loader->add($ns, $paths);
        foreach ($loader_conf['psr4'] as $ns => $paths) $loader->addPsr4($ns, $paths);
        $loader->register();

        // Aliases.
        foreach ($loader_conf['aliases'] as $alias => $class) class_alias($class, $alias);
    }

    protected function connectDatabase()
    {
        // Create database connection and set as global, in case anything else needs it.
        $db_conf = $this->getConfig('database');

        $this->capsule = new Capsule;
        $this->capsule->addConnection($db_conf);
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    protected function updateFlight()
    {
        // Some sane defaults for Flight.
        \Flight::set('flight.handle_errors', false);
        \Flight::set('flight.log_errors', true);
        \Flight::set('flight.views.path', APP_DIR . '/views');
    }

    protected function loadTwig()
    {
        // Load Twig.
        $twig_conf = $this->getConfig('twig');

        $this->twig_loader = new Twig_Loader_Filesystem(\Flight::get('flight.views.path'));
        $this->twig = new Twig_Environment($this->twig_loader, array_merge([
            'cache'   => STORE_DIR . '/twig'
        ], $twig_conf['loader']));

        // Apply configuration.
        foreach ($twig_conf['extensions'] as $ext => $args) $this->twig->addExtension(new $ext($args));
        foreach ($twig_conf['globals'] as $name => $val) $this->twig->addGlobal($name, $val);

        // Map Twig to Flight's native render function.
        \Flight::map('render', function ($template, $data = []) {
            return $this->twig->render($template, $data);
        });
    }
}
