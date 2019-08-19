<?php

namespace App\Controller;

use App\Entity\ExtraInformationRequest;
use App\Form\ExtraInformationRequestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/extra/information/request")
 */
class ExtraInformationRequestController extends AbstractController
{
    /**
     * @Route("/", name="extra_information_request_index", methods={"GET"})
     */
    public function index(): Response
    {
        $extraInformationRequests = $this->getDoctrine()
            ->getRepository(ExtraInformationRequest::class)
            ->findAll();

        return $this->render('extra_information_request/index.html.twig', [
            'extra_information_requests' => $extraInformationRequests,
        ]);
    }

    /**
     * @Route("/new", name="extra_information_request_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $extraInformationRequest = new ExtraInformationRequest();
        $form = $this->createForm(ExtraInformationRequestType::class, $extraInformationRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($extraInformationRequest);
            $entityManager->flush();

            return $this->redirectToRoute('extra_information_request_index');
        }

        return $this->render('extra_information_request/new.html.twig', [
            'extra_information_request' => $extraInformationRequest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="extra_information_request_show", methods={"GET"})
     */
    public function show(ExtraInformationRequest $extraInformationRequest): Response
    {
        return $this->render('extra_information_request/show.html.twig', [
            'extra_information_request' => $extraInformationRequest,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="extra_information_request_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ExtraInformationRequest $extraInformationRequest): Response
    {
        $form = $this->createForm(ExtraInformationRequestType::class, $extraInformationRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('extra_information_request_index', [
                'id' => $extraInformationRequest->getId(),
            ]);
        }

        return $this->render('extra_information_request/edit.html.twig', [
            'extra_information_request' => $extraInformationRequest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="extra_information_request_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ExtraInformationRequest $extraInformationRequest): Response
    {
        if ($this->isCsrfTokenValid('delete'.$extraInformationRequest->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($extraInformationRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('extra_information_request_index');
    }
}
