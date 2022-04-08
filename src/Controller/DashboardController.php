<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\WorktimeRepository;
use App\Service\Evaluation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private $worktimeRepository;
    public function __construct(WorktimeRepository $worktimeRepository, Evaluation $evaluation)
    {
        $this->worktimeRepository = $worktimeRepository;
        $this->evaluation = $evaluation;
    }

    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function index(): Response
    {

        $worktimes = $this->worktimeRepository->findAllUsersWorktimes();

        //dd($worktimes);
        return $this->render('dashboard/data.html.twig', [
            'worktimes'=>$worktimes, 'title'=> 'Dashboard'
        ]);
    }

    /**
     * @Route("/dashboard/edit/{id}", methods={"GET"})
     */
    public function update($id):Response{
        $message = "Gib den Start ein";
        $worktime = $this->worktimeRepository->findUserWorktime($id);
        return $this->render('index/edit.html.twig',['title'=>'Edit a worktime', 'worktime'=>$worktime, 'message' =>$message,]);
    }

    /**
     * @Route("/dashboard/delete/{id}", methods={"GET"})
     */
    public function delete($id):Response{
        $worktime = $this->worktimeRepository->find($id);
        $this->worktimeRepository->remove($worktime);
        return $this->redirectToRoute("app_dashboard");
    }

    /**
     * @Route("/dashboard/user/{id}", methods={"GET"})
     */
    public function displayUserDatas($id)
    {
        $worktimes = $this->worktimeRepository->findWorktimesByUser($id);
        $initial = new \DateTime('00:00:00');
        return $this->render('dashboard/userTimes.html.twig',['title'=>'Daten eines Users', 'worktimes'=>$worktimes, 'initial'=>$initial]);
    }
}
