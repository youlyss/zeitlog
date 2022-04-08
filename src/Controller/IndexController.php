<?php

namespace App\Controller;


use App\Entity\User;
use App\Entity\Worktime;
use App\Form\WorktimeType;
use App\Repository\UserRepository;
use App\Repository\WorktimeRepository;
use App\Service\FormHandler;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class IndexController extends AbstractController
{

    private $manager;
    public function __construct(WorktimeRepository $worktimeRepository, UserRepository $userRepository,  EntityManagerInterface $manager, RequestStack $requestStack)
    {
        $this->worktimeRepository = $worktimeRepository;
        $this->userRepository = $userRepository;
        $this->manager = $manager;
        $this->session = $requestStack->getSession();

    }

    /**
     * @Route("/", name="add_time")
     */
    public function form():Response
    {
        if ($this->getUser()) {
            $message = "Gib den Start ein";
            return $this->render('index/form.html.twig',['title'=>'Worktime',  'message' =>$message,]);
        }
        return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/savedata")
     */
    public function saveData(Request $request):Response
    {
         $starttime = $request->get('start_time');
         $endtime = $request->get('end_time');
         $userId = $request->get('user_id');
         $worktimeId = $request->get('worktime_id');


         $user = $this->userRepository->find($userId);
         if ($worktimeId!= null) {
             $worktime = $this->worktimeRepository->find($worktimeId);
         }else {
             $worktime = new Worktime();
         }
             $worktime
                 ->setStartTime(new DateTime($starttime))
                 ->setEndTime(new DateTime($endtime))
                 ->setUser($user);
             $this->manager->persist($worktime);
             $this->manager->flush();

         $message = "Starttime saved";

         return $this->render('index/form.html.twig', [
            'title' => 'Work',
            'message' =>$message
        ]);


    }
}

