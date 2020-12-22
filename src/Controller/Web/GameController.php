<?php

namespace App\Controller\Web;

use App\Entity\Game;
use App\Form\GameType;
use App\Message\Game\GameCreated;
use App\Message\Game\GameUpdated;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game")
 */
class GameController extends AbstractController
{
    /**
     * @Route("/", name="web_game_index")
     * @param Request $request
     * @param GameRepository $gameRepository
     * @return Response
     */
    public function index(Request $request, GameRepository $gameRepository): Response
    {
        return $this->render('game/index.html.twig', [
            'games' => $gameRepository->findAll()
        ]);
    }

    /**
     * @Route("/show/{game}", name="web_game_show")
     * @param Request $request
     * @param Game $game
     * @return Response
     */
    public function show(Request $request, Game $game): Response
    {
        return $this->render('game/show.html.twig', [
            'game' => $game
        ]);
    }

    /**
     * @Route("/create", name="web_game_create")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function create(Request $request)
    {
        $game = new Game();
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dispatchMessage(new GameCreated(json_encode($game->dto())));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('web_game_index');
        }

        return $this->render('game/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{game}", name="web_game_edit")
     * @param Request $request
     * @param Game $game
     * @return Response
     */
    public function edit(Request $request, Game $game): Response
    {
        $form = $this->createForm(GameType::class, $game);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->dispatchMessage(new GameUpdated(json_encode($game->dto())));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($game);
            $entityManager->flush();

            return $this->redirectToRoute('web_game_index');
        }

        return $this->render('game/edit.html.twig', [
            'form' => $form->createView(),
            'game' => $game
        ]);
    }
}
