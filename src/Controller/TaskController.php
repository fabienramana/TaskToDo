<?php


namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function getTasks() {
        $number = random_int(0, 100);

        return $this->render('tasks/tasks.html.twig', []);
    }

}