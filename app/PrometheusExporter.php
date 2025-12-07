<?php

namespace App;

use Prometheus\CollectorRegistry;
use Prometheus\Storage\APC;

class PrometheusExporter
{
    private static $registry = null;

    public static function getRegistry()
    {
        if (self::$registry === null) {
            self::$registry = new CollectorRegistry(new APC());
        }

        return self::$registry;
    }
}
