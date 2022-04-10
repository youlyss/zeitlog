<?php

namespace App\Controller;

use App\Entity\Project;
use App\Entity\UserProject;
use App\Form\ProjectFormType;
use App\Form\UserProjectFormType;
use App\Repository\ProjectRepository;
use App\Repository\UserProjectRepository;
use App\Repository\UserRepository;
use App\Repository\WorktimeRepository;

use App\Service\DateService;
use App\Service\FileService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class DashboardController extends AbstractController
{
    private $worktimeRepository;
    public function __construct(WorktimeRepository $worktimeRepository,
                                DateService $dateService,
                                FileService $fileService,
                                UserProjectRepository $userProjectRepository,
                                UserRepository $userRepository,
                                ProjectRepository $projectRepository,
                                EntityManagerInterface $manager
    )
    {
        $this->worktimeRepository = $worktimeRepository;
        $this->dateService = $dateService;
        $this->fileService = $fileService;
        $this->userProjectRepository = $userProjectRepository;
        $this->userRepository = $userRepository;
        $this->projectRepository = $projectRepository;
        $this->manager = $manager;
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

        $worktimes = $this->userProjectRepository->findAllProjectsUsersWorktimes();
        return $this->render('dashboard/data.html.twig', [
            'worktimes'=>$worktimes, 'title'=> 'Working Times - Users'
        ]);
    }

    /**
     * @Route("/dashboard/edit/{id}", name="app_edit_time", methods={"GET"})
     */
    public function update($id):Response
    {
        $worktime = $this->worktimeRepository->findUserWorktime($id);
        return $this->render('index/edit.html.twig',['title'=>'Edit a worktime', 'worktime'=>$worktime]);
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
     * @Route("/dashboard/filter/user/{id}", name="app_filter_user", methods={"GET"})
     */
    public function filterUserProjects($id):Response
    {
        $worktimes = $this->worktimeRepository->findByWorktimesByUser($id);
        $total = $this->dateService->calculateWorktimes($id);
        return $this->render('dashboard/userTimes.html.twig',['title'=>'Daten eines Users', 'worktimes'=>$worktimes, 'total'=>$total]);
    }
    /**
    * @Route("/dashboard/filter/project/{id}", name="app_filter_project", methods={"GET"})
    */
    public function filterProjects($id):Response
    {
        $worktimes = $this->worktimeRepository->findByWorktimesByProject($id);
        $total = $this->dateService->calculateWorktimesByProject($id);
        return $this->render('dashboard/userTimes.html.twig',['title'=>'Daten eines Users', 'worktimes'=>$worktimes, 'total'=>$total]);
    }



    /**
     * @Route("/export", name="app_export")
     */
    public function export():Response
    {
        $worktimes = $this->worktimeRepository->findAllUsersWorktimes();
        return $this->fileService->createCsvFile($worktimes);
    }

    /**
     * @Route("/list/users", name="app_list_users")
     */
    public function listUsers():Response
    {
        $users = $this->userRepository->findAll();
        return $this->render('dashboard/listUsers.html.twig',['title'=>'ListUsers', 'users'=>$users]);

    }

    /**
     * @Route("/list/project/user", name="app_project_user")
     */
    public function displayUser2Project():Response
    {
        $users = $this->userRepository->findAll();
        $projects = $this->projectRepository->findAll();
        return $this->render('dashboard/userToProject.html.twig',['title'=>'User2Project', 'users'=>$users, 'projects'=>$projects]);
    }
    /**
     * @Route("/assign/user/project", name="app_assign_user_project")
     */
    public function assignUser2Project(Request $request):Response
    {
        $userId = (int)$request->get('user_id');
        $projectId = (int)$request->get('project_id');

        $project = $this->projectRepository->find($projectId);
        $user = $this->userRepository->find($userId);

        $userProject = new UserProject();
        $userProject->setUser($user);
        $userProject->setProject($project);

        $this->manager->persist($userProject);
        $this->manager->flush();
        $users = $this->userRepository->findAll();
        $projects = $this->projectRepository->findAll();
        return $this->render('dashboard/userToProject.html.twig',['title'=>'User2Project', 'users'=>$users, 'projects'=>$projects]);
    }
}
