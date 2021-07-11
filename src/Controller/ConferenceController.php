<?php

namespace App\Controller;

use App\Entity\Conference;
use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ConferenceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConferenceController extends AbstractController
{
    /**
     * @Route("/conference", name="homepage")
     */
    public function index(ConferenceRepository $repository): Response
    {
        return $this->render('conference/index.html.twig', array(
            'conferences' => $repository->findAll()
        ));
    }

    /**
     * @Route("/conference/{id}", name="conference")
     */

    public function show(
        Request $request,
        Conference $conference,
        CommentRepository $commentRepository,
        PaginatorInterface $paginator,
        ConferenceRepository $conferenceRepository
    )
    {
        $pagination = $paginator->paginate(
            $commentRepository->getCommentsQuery($conference),
            $request->query->getInt('page', 1), /* page number */
            2 /* limit per page */
        );

        return $this->render('conference/show.html.twig', array(
            'conferences' => $conferenceRepository->findAll(),
            'conference' => $conference,
            'comments' => $pagination
        ));
    }
}
