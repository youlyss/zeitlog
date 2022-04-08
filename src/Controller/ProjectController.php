<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjectController extends AbstractController
{
    /**
     * @Route("/project/form", name="app_project")
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


}
