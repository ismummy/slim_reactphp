<?php


use Psr\Container\ContainerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

class HomeController
{
    protected $container;
    protected  $table;
    protected $logger;
    private $hello =0;


    // constructor receives container instance
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $this->logger = $container->get('logger');
        $this->table =  $container->get('db')->table('table_name');
    }

    public function home( $request,  $response)
    {
        $this->logger->addInfo("Ticket list");

        $response->getBody()->write('Hi, I am here'. $this->hello++);
        return $response;
    }
}