<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @property ObjectManager em
 */
class JdPropertyController extends AbstractController
{
    private $repository;

    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/biens", name="jd_property")
     * @return Response
     */
    public function index(): Response
    {
        $property = $this->repository->findAllVisible();
        dump($property);
        return $this->render('jd_property/property.html.twig', [
            'current_menu'          => 'properties',
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="jd_show", requirements={"slug": "[a-z0-9A-Z\-]*"})
     * @param Property $property
     * @param string $slug
     * @return Response
     */
    public function jdShow(Property $property, string $slug): Response
    {
        if($property->getSlug() !== $slug)
        {
            return $this->redirectToRoute('jd_show',
            [
                'id'        => $property->getId(),
                'slug'      => $property->getSlug()
            ], 301
            );
        }
        return $this->render('jd_property/propertySlug.html.twig',
            [
                'property'           => $property,
                'current_menu'      => 'properties',
            ]);
    }
}
