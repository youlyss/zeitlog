<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\WorktimeRepository;

use App\Service\DateService;
use App\Service\FileService;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractController
{
    private $worktimeRepository;
    public function __construct(WorktimeRepository $worktimeRepository,DateService $dateService, FileService $fileService)
    {
        $this->worktimeRepository = $worktimeRepository;
        $this->dateService = $dateService;
        $this->fileService = $fileService;
    }
    /**
     * @Route("/dashboard", name="app_dashboard")
     */

    public function dashboard():Response
    {
        return $this->render('dashboard/dashboard.html.twig', ['title'=>'Verwaltung']);
    }

    /**
     * @Route("/workingTime", name="app_working_time")
     */
    public function manageWorktime(): Response
    {
        $worktimes = $this->worktimeRepository->findAllUsersWorktimes();
        return $this->render('dashboard/data.html.twig', [
            'worktimes'=>$worktimes, 'title'=> 'Dashboard'
        ]);
    }

    /**
     * @Route("/dashboard/edit/{id}", name="app_edit_time", methods={"GET"})
     */
    public function update($id):Response
    {
        $message = "Gib den Start ein";
        $worktime = $this->worktimeRepository->findUserWorktime($id);
        return $this->render('index/edit.html.twig',['title'=>'Edit a worktime', 'worktime'=>$worktime, 'message' =>$message,]);
    }

    /**
     * @Route("/dashboard/delete/{id}", name="app_delete_time", methods={"GET"})
     */
    public function delete($id):Response
    {
        $worktime = $this->worktimeRepository->find($id);
        $this->worktimeRepository->remove($worktime);
        return $this->redirectToRoute("app_working_time");
    }

    /**
     * @Route("/dashboard/user/{id}", name="app_edit_user", methods={"GET"})
     */
    public function displayUserDatas($id):Response
    {
        $worktimes = $this->worktimeRepository->findWorktimesByUser($id);
        $total = $this->dateService->calculateWorktimes($id);
        return $this->render('dashboard/userTimes.html.twig',['title'=>'Daten eines Users', 'worktimes'=>$worktimes, 'total'=>$total]);
    }

    /**
     * @Route("/export", name="app_export")
     */
    public function export()
    {
        $worktimes = $this->worktimeRepository->findAllUsersWorktimes();
        return $this->fileService->createCsvFile($worktimes);
    }


}
