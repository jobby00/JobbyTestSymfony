<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JdHomeController extends AbstractController
{
    /**
     * @Route("/", name="jd_home")
     * @param PropertyRepository $repository
     * @return Response
     */
    public function index(PropertyRepository $repository): Response
    {
        $properties = $repository->findLastest();
        return $this->render('jd_home_controller/home.html.twig', [
            'properties'        => $properties,
        ]);
    }
}
