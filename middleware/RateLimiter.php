<?php
class RateLimiter {
    private $storage;
    private $window;
    private $maxRequests;

    public function __construct($window = 1, $maxRequests = 1) {
        $this->window = $window;
        $this->maxRequests = $maxRequests;
        $this->storage = sys_get_temp_dir() . '/rate_limits/';
        
        if (!is_dir($this->storage)) {
            mkdir($this->storage, 0755, true);
        }
    }

    public function checkLimit($key) {
        $file = $this->storage . md5($key);
        $current = time();
        $requests = [];

        $fp = fopen($file, 'c+');
        if (!$fp) {
            throw new Exception("Could not open rate limit file");
        }

        if (!flock($fp, LOCK_EX)) {
            fclose($fp);
            throw new Exception("Could not lock rate limit file");
        }

        $content = '';
        while (!feof($fp)) {
            $content .= fread($fp, 8192);
        }

        if (!empty($content)) {
            $requests = unserialize($content);
            // Remove old requests
            $requests = array_filter($requests, function($timestamp) use ($current) {
                return $timestamp > ($current - $this->window);
            });
            $requests = array_values($requests); // Re-index array
        }

        $count = count($requests);

        // Strictly check if we've hit the limit
        if ($count >= $this->maxRequests) {
            flock($fp, LOCK_UN);
            fclose($fp);
            return [false, 0];
        }

        // Add new request and update file
        $requests[] = $current;
        ftruncate($fp, 0);
        rewind($fp);
        fwrite($fp, serialize($requests));

        flock($fp, LOCK_UN);
        fclose($fp);

        return [true, $this->maxRequests - count($requests)];
    }

    public function getRemainingRequests($key) {
        list($allowed, $remaining) = $this->checkLimit($key);
        return max(0, $remaining);
    }
}
