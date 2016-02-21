<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Responder;

class HttpResponder extends Responder
{
    protected $statusCode = 200;

    protected $payload = '';

    protected $statusMessages = [
        200 => 'OK',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        500 => 'Internal Server Error',
    ];

    public function found(string $payload = '')
    {
        $this->payload = $payload;
        $this->statusCode = 200;
        $this->respond();
    }

    public function notFound()
    {
        $this->statusCode = 404;
        $this->respond();
    }

    public function methodNotAllowed()
    {
        $this->statusCode = 405;
        $this->respond();
    }

    public function error(string $payload = '')
    {
        $this->payload = $payload;
        $this->statusCode = 500;
        $this->respond();
    }

    protected function respond()
    {
        $statusMessage = $this->statusMessages[$this->statusCode];
        $header = sprintf('HTTP/1.1 %d %s', $this->statusCode, $statusMessage);
        header($header);
        if (!empty($this->payload)) {
            echo $this->payload;
        }
    }
}
