<?php

namespace App\Controllers\Backend;

use App\Libraries\API;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Base
 *
 * Base controller for the backend area. It provides a convenient place for
 * loading components and performing functions that are needed by all backend
 * controllers.
 *
 * For security, be sure to declare any new methods as protected or private.
 */
class Base extends \App\Controllers\BaseController
{
    /**
     * Buat call API
     */
    protected API $api;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend this controller.
     *
     * @var list<string>
     */
    protected $helpers = [
        'html',
        'form',
        'http_response',
    ];

    /**
     * Buat nampung nama class/controller yang dipanggil.
     * Untuk menyeragamkan seluruh nama file, mulai dari
     * Controller, Model, View, JS, dll.
     */
    protected string $class = '';

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger): void
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->api = new API();

        $ctrl = explode('\\', service('router')->controllerName());
        $this->class = (string) end($ctrl);
    }
}
