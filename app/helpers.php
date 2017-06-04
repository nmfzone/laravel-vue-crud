<?php

if (! function_exists('updateDotEnv')) {
    /**
     * Update the .env value based on the given data.
     *
     * @param  array   $data
     * @return boolean
     */
    function updateDotEnv($data = [])
    {
        if (count($data) > 0) {
            $env = file_get_contents(base_path() . '/.env');
            $env = explode(PHP_EOL, $env);

            foreach ($data as $key => $value) {
                foreach ($env as $env_key => $env_value) {
                    $entry = explode("=", $env_value, 2);
                    if ($entry[0] == $key) {
                        $env[$env_key] = $key . "=" . $value;
                    } else {
                        $env[$env_key] = $env_value;
                    }
                }
            }

            $env = implode("\n", $env);
            file_put_contents(base_path() . '/.env', $env);

            return true;
        }

        return false;
    }
}
