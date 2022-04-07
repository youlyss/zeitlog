<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\WorktimeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    private $worktimeRepository;
    public function __construct(WorktimeRepository $worktimeRepository)
    {
        $this->worktimeRepository = $worktimeRepository;
    }

    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function index(): Response
    {
        $worktimes = $this->worktimeRepository->findAll();
        return $this->render('dashboard/index.html.twig', [
            'worktimes'=>$worktimes, 'title'=> 'Dashboard'
        ]);
    }

    /**
     * @Route("/dashboard/edit/{id}", methods={"GET"})
     */
    public function update($id):Response{
        $message = "Gib den Start ein";
        $worktime = $this->worktimeRepository->findUserWorktime($id);
        //dd($worktime);
        return $this->render('index/edit.html.twig',['title'=>'Edit a worktime', 'worktime'=>$worktime, 'message' =>$message,]);
    }

    /**
     * @Route("/dashboard/delete/{id}", methods={"GET"})
     */
    public function delete($id):Response{
        $message = "Gib den Start ein";
        $worktime = $this->worktimeRepository->find($id);
        $this->worktimeRepository->remove($worktime);
        return $this->redirectToRoute("app_dashboard");
    }
}
