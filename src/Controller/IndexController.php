<?php

namespace App\Controller;



use App\Entity\Worktime;
use App\Repository\UserRepository;
use App\Repository\WorktimeRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


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
    public function form(RequestStack $request):Response
    {
        if ($this->getUser()) {
            $id = $this->getUser()->getId();
            $worktime = $this->worktimeRepository->findBylastUserWorktime($id);
            if ($worktime!=null){
                return $this->render('index/edit.html.twig',['title'=>'Worktime', 'worktime' => $worktime]);
            }
            return $this->render('index/form.html.twig',['title'=>'Worktime']);
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

         if ($starttime!=null) {
             $user = $this->userRepository->find($userId);
             if ($worktimeId != null) {
                 $worktime = $this->worktimeRepository->find($worktimeId);
             } else {
                 $worktime = new Worktime();
             }
             $worktime->setStartTime(new DateTime($starttime));
             if ($endtime!=null){
                 $worktime->setEndTime(new DateTime($endtime));
             }
             $worktime->setUser($user);
             $this->manager->persist($worktime);
             $this->manager->flush();

         }
        return $this->redirectToRoute('app_dashboard');



    }
}

