<?php
namespace Cs\Services;

use Cs\Util\Util;

Class Logger extends Util {
    public function __construct($app, $config) {
        $this->app = $app;
        $this->config = $config;
        self::validateLogPath($config);
        $this->logFilePath = $config['log_path'];
    }

    public function log(Array $log): Void {
        if (self::isAssoc($log) === false) {
            throw new InvalidData("the.given.log.info.is.not.associative.array");
        }

        self::validateLog($log);
        if (\array_key_exists('time', $log) === false) {
            $log['time'] = time();
        }

        $logString = json_encode($log);
        $adapter = $this->getContext('adapter', $this->config);
        $adapter->write($logString, $this->logFilePath);
    }
}