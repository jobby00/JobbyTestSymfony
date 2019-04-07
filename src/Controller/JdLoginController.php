<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class JdLoginController extends AbstractController
{
    /**
     * @Route("/login", name="jd_login")
     */
    public function index()
    {
        return $this->render('jd_login/index.html.twig', [
            'controller_name' => 'JdLoginController',
        ]);
    }
}
