<?php

namespace Retrofico\Retrofico;

use Illuminate\Config\Repository;
use Retrofico\Retrofico\Exceptions\ConfigFileNotFoundException;

/**
 * Class Config
 */
class Config
{

    /**
     * Config file name
     */
    const CONFIG_FILE_NAME = "retrofico";

    /**
     * @var  \Illuminate\Config\Repository
     */
    private $config;

    /**
     * Config constructor. If not using environement variables or to override
     * them, a `team_id` and an `api_key` can be manually passed.
     *
     * @param string|null $team_id
     * @param string|null $api_key
     */
    public function __construct(?string $team_id = null, ?string $api_key = null)
    {
        $configPath = $this->configurationPath();

        $config_file = $configPath . '/' . self::CONFIG_FILE_NAME . '.php';

        if (!file_exists($config_file)) {
            throw new ConfigFileNotFoundException();
        }

        $this->config = new Repository(require $config_file);

        if ($team_id) {
            $this->config->set("team_id", $team_id);
        }

        if ($api_key) {
            $this->config->set("api_key", $api_key);
        }

    }

    /**
     * return the correct config directory path
     *
     * @return  mixed|string
     */
    private function configurationPath()
    {
        // the config file of the package directory
        $config_path = __DIR__ . '/Config';

        // check if this laravel specific function `config_path()` exist (means this package is used inside
        // a laravel framework). If so then load then try to load the laravel config file if it exist.
        if (function_exists('config_path')) {
            $config_path = config_path();
        }

        return $config_path;
    }

    /**
     * @param $key
     *
     * @return  mixed
     */
    public function get($key)
    {
        return $this->config->get($key);
    }
}
