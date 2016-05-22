<?php

namespace Jbt\KevinBoussardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;

/**
 * Search controller.
 *
 */
class SearchController extends Controller
{
    public function indexAction(Request $request)
    {
        return $this->render('JbtKevinBoussardBundle:Search:index.html.twig');
    }
}
