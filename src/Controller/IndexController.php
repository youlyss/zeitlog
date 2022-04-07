<?php

namespace App\Controller;


use App\Entity\Worktime;
use App\Form\WorktimeType;
use App\Repository\WorktimeRepository;
use App\Service\FormHandler;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    private $manager;
    public function __construct(WorktimeRepository $worktimeRepository, EntityManagerInterface $manager)
    {
        $this->worktimeRepository = $worktimeRepository;
        $this->manager = $manager;

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
     * @Route("/", name="add_time")
     */
    public function form():Response{
        $message = "Gib den Start ein";
        return $this->render('index/form.html.twig',['title'=>'Worktime',  'message' =>$message,]);
    }




    /**
     * @Route("/savedata")
     */
    public function saveData(Request $request):Response
    {
         $starttime = $request->get('start_time');
         $endtime = $request->get('end_time');
         $worktime = new Worktime();
         $worktime
             ->setStartTime(new DateTime($starttime))
             ->setEndTime(new DateTime($endtime));
         $this->manager->persist($worktime);
         $this->manager->flush();
         $message = "Starttime saved";

         return $this->render('index/form.html.twig', [
            'title' => 'Work',
            'message' =>$message
        ]);


    }
}

