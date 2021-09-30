<?php

namespace App\DataFixtures;

use App\Entity\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use DateTime;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $task1 = new Task();
        $task1->setTitle("testTitle1");
        $task1->setDescription("testDescription1");
        $task1->setCreationTimestamp(new DateTime('2021-09-30T08:39:16+00:00'));
        $task1->setIsDone(false);
        $manager->persist($task1);

        $task2 = new Task();
        $task2->setTitle("testTitle2");
        $task2->setDescription("testDescription2");
        $task2->setCreationTimestamp(new DateTime('2021-09-30T08:39:16+00:00'));
        $task2->setIsDone(false);
        $manager->persist($task2);

        $manager->flush();
    }
}
