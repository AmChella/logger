<?php
namespace Cs\Logger\Util;

use Cs\Util\Exceptions\EmptyData;
use Cs\Util\Exceptions\InvalidData;
use Cs\Util\Exceptions\MissingLogKey;

Class Util {
    public static function isAssoc(Array $data): Bool {
        return array_keys($data) !== range(0, count($data) - 1);
    }

    public static function isKeyAvailable(Array $app, String $key): Bool {
        if (self::isEmpty($key) === true) {
            throw new EmptyData("$$key.is.empty");
        }

        if (self::isAssoc($app) === false) {
            throw new InvalidData("variable.is.not.an.associative");
        }

        return array_key_exists($app, $key);
    }

    public function validateLog(Array $log): Bool {
        $requriedKeys = ['type', 'module', 'method', 'message', 'state'];
        $missingKeys = [];
        foreach($requriedKeys as $item) {
            if (self::isKeyAvailable($log, $item) === false) {
                array_push($missingKeys, $item);
            }
        }

        if (count($missingKeys) > 0) {
            $keys = \implode(",", $missingKeys);
            throw new MissingLogKey("the.items.are.not.found.in.the.log.$keys");
        }

        return true;
    }

    public function getContext(String $key, ...$arg): Object {
        if (self::isAvailable($this->app, $key) === false) {
            throw new NotFound("$key.the.object.not.available");
        }

        return \call_user_func($this->app[$key], $arg);
    }

    public static function validateLogPath(Array $config): Bool {
        if (self::isKeyAvailable($config, 'log_path') === false) {
            throw new MissingLogKey("the.log.path.is.missing");
        }

        return true;
    }
}