<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Task;
use App\Form\TaskType;

class TaskController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function getTasks() {

        $em = $this->getDoctrine()->getManager();
        $tasks = $em->getRepository('App:Task')->findAll();

        return $this->render('tasks/tasks.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function createTask(Request $request) {

        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $task->setCreatedAt(new \Datetime("now"));
            $task->setUpdatedAt(new \Datetime("now"));

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect($this->generateUrl('home'));

        }

        return $this->render('tasks/create-task.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/update/{id}", name="update")
     */
    public function updateTask($id, Request $request) {
        $em = $this->getDoctrine()->getManager();

        $task = $em->getRepository('App:Task')->findOneById($id);
        
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $task = $form->getData();
            $task->setUpdatedAt(new \Datetime("now"));

            $em->persist($task);
            $em->flush();

            return $this->redirect($this->generateUrl('home'));
        }

        return $this->render('tasks/update-task.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteTask($id) {
        $em = $this->getDoctrine()->getManager();

        $taskToDelete = $em->getRepository('App:Task')->findOneById($id);
        
        $em->remove($taskToDelete);
        $em->flush();

        return $this->redirect($this->generateUrl('home'));
    }

}