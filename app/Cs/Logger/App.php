<?php
namespace Cs\Logger;

use Exception;
use Cs\Util\Util;
use Cs\Util\Exceptions\InvalidData;

Class App extends Util {
    private $app;
    public function __construct(Array $config) {
        $this->setup($config);
    }

    public function setup($config): Void {
        if (self::isAssoc($config) === false) {
            throw new InvalidData("the.configuration.should.be.associate.of.array");
        }

        $app['logger'] = function($customArg) use($app) {
            return new Logger($app, $customArg);
        };

        $app['adapter'] = function($customArg) use($app) {
            return new Adapter($customArg);
        };
    }
}
