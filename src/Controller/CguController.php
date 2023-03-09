<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Form\SearchType;
use App\Functions\Construct;
use App\Model\SearchData;
use App\Repository\MessageRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CguController extends Construct
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, MessageRepository $messageRepo): Response
    {

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_home', ['formationSearch' => http_build_query($searchData)]);
        } 

        $message = new Message();
        $messageForm = $this->createForm(MessageType::class, $message);
        $messageForm->handleRequest($request);

        if ($messageForm->isSubmitted() && $messageForm->isValid()) {
            $messageRepo->save($message, true);
            return $this->redirectToRoute('app_contact');
        }

        return $this->render('cgu/index.html.twig', [
            'Page_title'          => "Contacter-nous",
            'universities'        => $this->universities,
            'sanctions'           => $this->sanctions,
            'categories'          => $this->categories,
            'form'                => $form->createView(),
            'messageForm'         => $messageForm->createView()
        ]);
    }

    #[Route('/mention-legale', name: 'app_mention')]
    public function mention(Request $request): Response
    {

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_home', ['formationSearch' => http_build_query($searchData)]);
        }

        return $this->render('cgu/mention.html.twig', [
            'Page_title'          => "Mentions legales",
            'universities'        => $this->universities,
            'sanctions'           => $this->sanctions,
            'categories'          => $this->categories,
            'form'                => $form->createView(),
        ]);
    }

    #[Route('/condition-utilisation', name: 'app_condition')]
    public function condition(Request $request): Response
    {

        $searchData = new SearchData();
        $form = $this->createForm(SearchType::class, $searchData);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->redirectToRoute('app_home', ['formationSearch' => http_build_query($searchData)]);
        }

        return $this->render('cgu/condition.html.twig', [
            'Page_title'          => "Condition d'utilisation",
            'universities'        => $this->universities,
            'sanctions'           => $this->sanctions,
            'categories'          => $this->categories,
            'form'                => $form->createView(),
        ]);
    }
}
