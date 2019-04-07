<?php

namespace App\Controller\Admin;

use App\Entity\Property;
use App\Form\PropertyType;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @property PropertyRepository repository
 * @property ObjectManager em
 */
class AdminPropertyController extends AbstractController
{
    public function __construct(PropertyRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin", name="jd_admin")
     */
    public function index(): Response
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/admin.html.twig', compact('properties'));
    }

    /**
     * @Route("/admin/bien/create", name="jd_create")
     * @param Request $request
     * @return Response
     */
    public function create( Request $request): Response
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->persist($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien Créé Avec Succè');
            return $this->redirectToRoute('jd_admin');
        }
        return $this->render('admin/property/create.html.twig', [
            'property'      => $property,
            'form'          => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/edit/{id}", name="jd_edit", methods="GET|POST" )
     * @param Property $property
     * @param Request $request
     * @return Response
     */
    public function edit(Property $property, Request $request): Response
    {
        $form = $this->createForm(PropertyType::class, $property);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $this->em->flush();
            $this->addFlash('success', 'Bien Modifié Avec Succè');
            return $this->redirectToRoute('jd_admin');
        }
        return $this->render('admin/property/edit.html.twig', [
            'property'      => $property,
            'form'          => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/delete/{id}", name="jd_delete", methods="DELETE" )
     * @param Property $property
     * @param Request $request
     * @return RedirectResponse
     */
    public function delete(Property $property, Request $request)
    {
        if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token')))
        {
            $this->em->remove($property);
            $this->em->flush();
            $this->addFlash('success', 'Bien Suprimé Avec Succè');
            return $this->redirectToRoute('jd_admin');
        }
    }
}
