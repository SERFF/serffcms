<?php
namespace Serff\Cms\Core\Common\Environment;

/**
 * Class Environment
 *
 * @package Serff\Cms\Core\Common\Environment
 */
class Environment
{

    /**
     * @param array $data
     */
    public function update(array $data = [])
    {
        $env = $this->getEnv();
        foreach ($data as $key => $value) {
            $env[ $key ] = $value;
            putenv("$key=$value");
        }
        
        $this->setEnv($env);
    }

    /**
     * @return array|string
     */
    protected function getEnv()
    {
        $env = file_get_contents(base_path() . '/.env');
        $env = preg_split('/\s+/', $env);
        $items = [];
        foreach ($env as $value) {
            $item = explode('=', $value);
            $items[ trim(array_get($item, 0)) ] = trim(array_get($item, 1));
        }

        return $items;
    }

    /**
     * @param array $env
     */
    protected function setEnv($env)
    {
        $env_content = '';
        foreach ($env as $key => $value) {
            if(strlen($key) > 0) {
                $env_content .= sprintf("%s=%s\n", $key, $value);
            }
        }
        
        file_put_contents(base_path() . '/.env', $env_content);
    }

}

