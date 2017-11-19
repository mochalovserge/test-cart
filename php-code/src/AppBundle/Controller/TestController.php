<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class TestController
 *
 * @package AppBundle\Controller
 * @author Mochalov Sergey <mochalov.serge@gmail.com>
 */
class TestController extends Controller
{
    /**
     * Matches /test/ exactly
     *
     * @Route("/test/", name="index_route")
     */
    public function indexAction()
    {
        return $this->render('test/index.html.twig', [

        ]);
    }

    /**
     * Matches /test/page/ exactly
     *
     * @Route("/test/page/", name="test_route")
     */
    public function pageAction()
    {
        return $this->render('test/page.html.twig', [

        ]);
    }
}
