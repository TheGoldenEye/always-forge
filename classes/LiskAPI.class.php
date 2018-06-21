<?php

class LiskAPI {
    private $_curl;

    public function __construct () {
        $this->_curl = CurlSingle::getInstance ();
    }

    public function setTimeout ($timeout = 3) {
        $this->_curl->setOption (CURLOPT_TIMEOUT, $timeout);
    }

    public function setConnectionTimeout ($connection_timeout = 1000) {
        $this->_curl->setOption (CURLOPT_CONNECTTIMEOUT_MS, $connection_timeout);
    }

    private function _send_request (&$server) {
        try {
            $result = $this->_curl->exec ();
        } catch (Exception $e) {
            Logger::log (Logger::WARNING, "[{$server->name}] " . $e->getMessage ());
            return false;
        }
        $json = json_decode($result);
        if (!isset ($json) || !isset ($json->data) || !$json->data) {
            return false;
        }
        Logger::log (Logger::DEBUG, "[{$server->name}] " . $result);
        return $json;
    }

    public function getStatus ($server) {
        $url = "{$server->scheme}://{$server->ip}:{$server->port}/api/node/status";
        $this->_curl->setUrl ($url);
        $this->_curl->setBody ("GET", null);
        return $this->_send_request ($server);
    }

    public function getForgingStatus ($server, $publicKey) {
        $url = "{$server->scheme}://{$server->ip}:{$server->port}/api/node/status/forging?publicKey={$publicKey}";
        $this->_curl->setUrl ($url);
        $this->_curl->setBody ("GET", null);
        return $this->_send_request ($server);
    }

    public function disableForging ($server, $password, $publicKey) {
        $url = "{$server->scheme}://{$server->ip}:{$server->port}/api/node/status/forging";
        $body = "{\"forging\": false, \"password\": \"{$password}\",\"publicKey\": \"{$publicKey}\"}";
        $this->_curl->setUrl ($url);
        $this->_curl->setBody ("PUT", $body);
        return $this->_send_request ($server);
    }

    public function enableForging ($server, $password, $publicKey) {
        $url = "{$server->scheme}://{$server->ip}:{$server->port}/api/node/status/forging";
        $body = "{\"forging\": true, \"password\": \"{$password}\",\"publicKey\": \"{$publicKey}\"}";
        $this->_curl->setUrl ($url);
        $this->_curl->setBody ("PUT", $body);
        return $this->_send_request ($server);
    }
}

?>
