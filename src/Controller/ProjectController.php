<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectFormType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{

    public function __construct(ProjectRepository $projectRepository){
        $this->projectRepository = $projectRepository;
    }
    /**
     * @Route("/project/form", name="app_project_form")
     */
    public function form(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project= new Project();
        $form = $this->createForm(ProjectFormType::class, $project);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();
        }
        return $this->render('project/form.html.twig', ['projectForm'=>$form->createView()]);


    }

    /**
     * @Route("/project/list", name="app_project_list")
     */
    public function list()
    {
        $projects = $this->projectRepository->findAll();
        return $this->render('project/list.html.twig',['title'=>'Liste von Projekte', 'projects'=>$projects]);
    }


}
