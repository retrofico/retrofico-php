<?php

namespace Retrofico\Retrofico;

use Illuminate\Config\Repository;

/**
 * Class Config
 */
class Config
{

    /**
     * Config file name
     */
    protected const CONFIG_FILE_NAME = "retrofico";

    /**
     * Base API path
     */
    public const API_BASE_PATH = "https://retrofi.co/api/";

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

        $config_file = $this->configurationFile();
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
    private function configurationFile(): string
    {
        // the config file of the package directory
        $config_path = __DIR__ . '/Config';

        $filename = '/' . self::CONFIG_FILE_NAME . '.php';

        // check if this laravel specific function `config_path()` exist (means this package is used inside
        // a laravel framework). If so then load then try to load the laravel config file if it exist.
        if (function_exists('config_path') && file_exists(config_path() . $filename)) {
            $config_path = config_path();
        }

        $config_file = $config_path . $filename;

        if (!file_exists($config_file)) {
            throw new ConfigFileNotFoundException();
        }

        return $config_file;
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
