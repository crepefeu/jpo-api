<?php
class Config {
    private static $config = null;

    public static function load() {
        if (self::$config === null) {
            self::$config = parse_ini_file(__DIR__ . '/../.env');
        }
        return self::$config;
    }

    public static function get($key) {
        if (self::$config === null) {
            self::load();
        }
        return isset(self::$config[$key]) ? self::$config[$key] : null;
    }
}
