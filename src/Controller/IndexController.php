<?php

namespace App\Controller;


use App\Form\WorktimeType;
use App\Repository\WorktimeRepository;
use App\Service\FormHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private $worktimeRepository;
    public function __construct(WorktimeRepository $worktimeRepository)
    {
        $this->worktimeRepository = $worktimeRepository;
    }

    /**
     * @Route("/index", name="app_index")
     */
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("/time", name="add_time")
     */
    public function form():Response{
        return $this->render('index/form.html.twig');
    }

    /**
     * @Route("/save")
     */
    public function saveFormdata(Request $request, FormHandler $formHandler):Response{
        $data = $request->request->all();

        $this->senderNumber = $data["start_time"];
        $this->senderMessage = $data["end_time"];

        $form = $this->createForm(WorktimeType::class, new WorktimeType());
        $form->submit($data);
        if (false === $form->isValid()) {
            $errors = $formHandler->getErrorsFromForm($form);
            return new JsonResponse(
                [
                    'message' => 'invalid Data',
                    'errors' => $errors
                ],
                JsonResponse::HTTP_BAD_REQUEST
            );
        }
        $this->worktimeRepository->persist($form->getData());
        $this->worktimeRepository->flush();
        $message = "";
        $messageNotice = "Vielen Dank für Ihre Nachricht. Sie erhalten eine Empfangsbestätigung per E-Mail";

        return $this->render('index/form.html.twig', [
            'title' => 'Add to ',
            'message' =>$message,
            'messageNotice'=>$messageNotice,
        ]);
    }
}
