<?php

namespace App\Entity;

use App\Repository\UserProjectRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserProjectRepository::class)
 */
class UserProject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Project")
     */
    private $project;

    /**
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getProject()
    {
        return $this->project;
    }


    public function setProject($project): self
    {
        $this->project = $project;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): self
    {
        $this->user = $user;
        return $this;
    }



    public function getId(): ?int
    {
        return $this->id;
    }
}
