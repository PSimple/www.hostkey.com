<?php

/**
 * Инструмент реализующий API запросы к Realtime
 *
 * @package Shop.Helper
 * @author Konstantin Shamiev aka ilosa <konstantin@shamiev.ru>
 * @date 2016.05.25
 */
class Shop_Helper_RealtimeRegister
{
    private $url = 'https://api.yoursrs-ote.com';

    private $handle = 'hostkey-ote';

    private $login = 'admin';

    private $password = '50ftWoman';

    /**
     * API Запрос к стороннему сервису (серверу)
     *
     * @param string $uri адрес запроса
     * @return mixed
     */
    public function GET($uri)
    {
        return $this->requestJson($uri, 'GET');
    }

    /**
     * API Запрос к стороннему сервису (серверу)
     *
     * @param string $uri адрес запроса
     * @param mixed $content тело запроса
     * @return mixed
     */
    public function POST($uri, $content = '')
    {
        return $this->requestJson($uri, 'POST', $content);
    }

    /**
     * API Запрос к стороннему сервису (серверу)
     *
     * @param string $uri адрес запроса
     * @param mixed $content тело запроса
     * @return mixed
     */
    public function PUT($uri, $content = '')
    {
        return $this->requestJson($uri, 'PUT', $content);
    }

    /**
     * API Запрос к стороннему сервису (серверу)
     *
     * @param string $uri адрес запроса
     * @return mixed
     */
    public function DELETE($uri)
    {
        return $this->requestJson($uri, 'DELETE');
    }

    /**
     * API Запрос к стороннему сервису (серверу)
     *
     * @param string $uri адрес запроса
     * @param string $method метод запроса
     * @param mixed $content тело запроса
     * @return mixed
     */
    private function requestJson($uri, $method, $content = '')
    {
        $key = $this->handle . '/' . $this->login . ':' . $this->password;
        $key = base64_encode($key);

        $content = json_encode($content, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
        $opts = array(
            'http' => array(
                'method' => $method,
                'header' => "Content-Type: application/json; charset=utf-8\r\n" . "Content-Length: " . strlen($content) . "\r\n" . "Authorization: Basic {$key}\r\n",
                'content' => $content,
                'timeout' => 30,
            )
        );
        $fp = fopen($this->url . $uri, 'rb', false, stream_context_create($opts));
        if ( $fp == false )
        {
            Zero_Logs::Set_Message_Error('Обращение к не корректному ресурсу: ' . $this->url . $uri);
            return null;
        }
        $response = stream_get_contents($fp);
        fclose($fp);
        $data = json_decode($response, true);
        if ( !$data )
            return $response;
        return $data;
    }
}
