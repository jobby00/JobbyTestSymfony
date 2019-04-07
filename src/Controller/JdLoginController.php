<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JdLoginController extends AbstractController
{
    /**
     * @Route("/login", name="jd_login")
     * @param User $user
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        $form = $this->createForm(UserType::class);
        $form->handleRequest($request);
        return $this->render('jd_login/login.html.twig', [
            'form'          => $form->createView(),
        ]);
    }
}
