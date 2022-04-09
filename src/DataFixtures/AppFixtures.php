<?php

namespace App\DataFixtures;


use App\Entity\Project;
use App\Entity\User;
use App\Entity\Worktime;
use App\Repository\UserRepository;
use App\Repository\WorktimeRepository;
use DateInterval;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture implements Constants
{

    public function __construct(UserPasswordHasherInterface $userPasswordHasher, WorktimeRepository $worktimeRepository, UserRepository $userRepository){
        $this->userPasswordHasher = $userPasswordHasher;
        $this->worktimeRepository= $worktimeRepository;
        $this->userRepository = $userRepository;
    }
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadWorkingTime($manager);
        $this->loadProject($manager);
        $manager->flush();
    }
    public function loadUsers(ObjectManager $manager){

        foreach (self::USERSDATA as $key => $userdata) {
            $user = new user();
            $user->setEmail($userdata['email']);
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $userdata['password']
                )
            );
            $this->setReference("user_$key", $user);
            $manager->persist($user);
        }
    }


    public function loadWorkingTime(ObjectManager $manager)
    {
          for ($i=0; $i<5; $i++){
            $ref = rand(0,4);
            $hours_to_add = rand(5,22);
            $worktime = new Worktime();
            $worktime->setStartTime(new \DateTime());

            $worktime->setEndTime((new \DateTime())->add(new DateInterval('PT' . $hours_to_add . 'H')));
            $userReference = $this->getReference("user_$ref");
            $worktime->setUser($userReference);
            $manager->persist($worktime);

            }
    }

    public function loadProject(ObjectManager $manager)
    {
        foreach (self::PROJECTS as $item){

            $project = new Project();
            $project->setName($item['name']);
            $project->setDescription($item['description']);
            $manager->persist($project);

        }
    }


}
