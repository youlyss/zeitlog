<?php

namespace App\DataFixtures;

interface Constants
{
    const USERSDATA =[
        [
            'email'=>'ericgreth@emailaing.com',
            'password'=>  'secretSIK$1',
        ],
        [
            'email'=>'brandters@ndxmails.com',
            'password'=>  'secretSIK$2',
        ],
        [
            'email'=>'ageeviv@dmxs8.com',
            'password'=>  'secretSIK$3',
        ],
        [
            'email'=>'innesm@gmailvn.net',
            'password'=>  'secretSIK$4',
        ],
        [
            'email'=>'jenslemmermann@aevtpet.com',
            'password'=>  'secretSIK$5',
        ],
    ];

    const PROJECTS =[
        [
            'name'=>'Frontend',
            'description'=>  'Frontend Project',
        ],
        [
            'name'=>'Backend',
            'description'=>  'Backend Project',
        ],
        [
            'name'=>'Dev ops',
            'description'=>  'Devops Project',
        ],
        [
            'name'=>'Security',
            'description'=>  'Security Project',
        ],
        [
            'name'=>'Quality Management',
            'description'=>  'Quality Managemant',
        ],
        [
            'name'=>'SEO ',
            'description'=>  'SEO ',
        ],
      ];
}