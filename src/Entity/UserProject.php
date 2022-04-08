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


    public function getId(): ?int
    {
        return $this->id;
    }
}
