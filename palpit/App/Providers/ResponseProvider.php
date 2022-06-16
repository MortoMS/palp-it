<?php

namespace App\Providers;

use App\Providers\ViewProvider;

use stdClass;

class ResponseProvider
{
    const TYPE_TEXT = 'TEXT';
    const TYPE_JSON = 'JSON';
    const TYPE_HTML = 'HTML';
    const TYPE_VIEW = 'VEIW';

    private $headers = [
        'Content-Type' => 'text/html; charset=utf-8', 
    ];

    private $statusCode = 200;
    private $body = []; 

    public function write(string $value): ResponseProvider
    {
        $body = new stdClass;

        $body->type  = self::TYPE_TEXT;
        $body->value = $value;

        array_push($this->body, $body);

        return $this;
    }

    public function json($data)
    {
        $body = new stdClass;

        $body->type  = self::TYPE_JSON;
        $body->value = $data;

        $this->headers['Content-Type'] = 'application/json; charset=utf-8';

        array_push($this->body, $body);

        return $this;
    }

    public function view(string $path, $data = []): ResponseProvider
    {
        $body = new stdClass;
        $view = new ViewProvider;

        $view->setPath($path);
        $view->setData($data);

        $body->type  = self::TYPE_VIEW;
        $body->value = $view;

        array_push($this->body, $body);

        return $this;
    }

    public function setCode(int $statusCode): ResponseProvider
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function render()
    {
        http_response_code($this->statusCode);
        
        if (count($this->headers) > 0) {
            foreach ($this->headers as $index => $value) {
                header($index . ': ' . $value, true);
            }
        }

        if (count($this->body) > 0) {
            foreach ($this->body as $body) {
                switch ($body->type) {
                    case self::TYPE_HTML:
                    case self::TYPE_TEXT:
                        echo $body->value;
                        break; 
                    case self::TYPE_JSON:
                        echo json_encode($body->value);
                        break;
                    case self::TYPE_VIEW:
                        echo call_user_func($body->value);
                        break;
                }
            }
        }
    }
}
