<?php

use Phalcon\Config;
use Phalcon\Config\ConfigFactory;

/**
 * Run up/down all the migrations.
 *
 * @param string $type
 * @return bool
 */
function run(string $type = 'up'): bool
{
    /** Initialize the Config */
    $factory  = new ConfigFactory();
    $fileName = __DIR__ . '/../configs/database.php';

    /** Create the Database Config */
    $config = $factory->newInstance('php', $fileName);

    if ($config instanceof Config) {
        $dns = "mysql:host=" . $config->options->host . ";dbname=" . $config->options->dbname;
        try {
            $db = new PDO($dns, $config->options->username, $config->options->password);
            $query = file_get_contents(__DIR__ . '/query-' . $type . '.sql');
            $db->query($query);

            return true;
        } catch (PDOException $ex) {
            return false;
        }
    }

    return false;
}

$acceptedParams = [
  'up',
  'down'
];

// check passed parameter and run the migrations
if (isset($argc) && isset($argv)) {
    if ($argc === 2 && isset($argv[1])) {
        $param = strtolower($argv[1]);
        if (in_array($param, $acceptedParams)) {
            if (run($param)) {
                echo "[Success] Migrations have been run " . $argv[1] . ".";
            } else {
                echo "[Failed] Migrations have not run correctly.";
            }
        } else {
            echo "[Failed] Wrong parameters. Accepted only 'up' or 'down'.";
        }
    } else {
        echo "[Failed] Wrong number of parameters passed.";
    }
} else {
    echo "[Failed] No parameters have been passed.";
}

