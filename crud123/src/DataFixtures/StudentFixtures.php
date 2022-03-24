<?php

namespace App\DataFixtures;

use App\Entity\Student;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StudentFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i=1; $i<=20; $i++) {
            $student = new Student;
            $student->setEmail("greenwich@fpt.edu.vn");
            $student->setName("Student $i");
            $student->setAddress("Ha Noi");
            $student->setGrade((float)(rand(0,10)));
            $student->setBirthday(\DateTime::createFromFormat('Y-m-d','1997-06-15'));
            $student->setImage("https://img.freepik.com/free-photo/portrait-attractive-cute-young-student-girl-isolated-white-wall_231208-1270.jpg?t=st=1648105570~exp=1648106170~hmac=0371cb4e08b95b1bd3158f15ea0eaa35c6bd617768a4a6a6c80f5892f74ab56d&w=996");
            $manager->persist($student);
        }

        $manager->flush();
    }
}
