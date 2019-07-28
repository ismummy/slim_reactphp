<?php


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class IPLogMiddleware
{

    protected $logger;

    /**
     * IPLo middleware invokable class
     *
     * @param ServerRequestInterface $request PSR7 request
     * @param ResponseInterface $response PSR7 response
     * @param callable $next Next middleware
     *
     * @return ResponseInterface
     */
    public function __invoke($request, $response, $next)
    {
        $response = $next($request, $response);
        $ip = $request->getAttribute('ip_address');
        $this->logger->info("[$ip]: " . $request->getUri());
        return $response;
    }

    public function __construct(Monolog\Logger $logger)
    {
        $this->logger = $logger;
    }
}