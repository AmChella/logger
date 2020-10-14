<?php
namespace Cs\Logger\Util;

use Cs\Util\Exceptions\EmptyData;
use Cs\Util\Exceptions\InvalidData;

Class Util {
    public static function isAssoc(Array $data): Bool {
        return array_keys($data) !== range(0, count($data) - 1);
    }

    public static function isKeyAvailable(Array $app, String $key): Bool {
        if (self::isEmpty($key) === true) {
            throw new EmptyData("$$key.is.empty");
        }

        if (self::isAssoc($app) === false) {
            throw new InvalidData("app.is.not.associative");
        }

        return array_key_exists($app, $key);
    }
}