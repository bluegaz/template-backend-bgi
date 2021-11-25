<?php

namespace App\Controllers\Backend;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use \App\Libraries\API;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class Base extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * Buat call API
     * 
     * @var API
     */
    protected $api;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [
        'html',
        'form',
    ];

    /**
     * Buat nampung nama class/controller yang dipanggil.
     * Untuk menyeragamkan seluruh nama file, mulai dari
     * Controller, Model, View, JS, dll.
     * 
     * @var string
     */
    protected $class;

    /**
     * 
     * @var Services::session
     */
    protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        $this->session = \Config\Services::session();
        $this->api = new API();
        
        $ctrl = explode('\\', service('router')->controllerName());
        $this->class = end($ctrl);
    }
}
