<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ClassroomController extends AbstractController
{
    /**
     * @Route("/", name="classroom")
     */
    public function index()
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ClassroomController.php',
        ]);
    }

    /**
     * @Route("/classrooms", name="get_all", methods={"GET"})
     * @return JsonResponse
     */
    public function GetAll() {
        return $this->json([
            'vasya' => 'petya',
        ]);
    }

    /**
     * @Route("/classroom/{id}", name="get_one", methods={"GET"})
     * @param int $id
     * @return JsonResponse
     */
    public function GetOne(int $id) {
        return $this->json([
            'vasya' => $id,
        ]);
    }
//
//    /**
//     * @Route("/classroom", name="create", methods={"POST"})
//     * @param Classroom $classroom
//     * @return JsonResponse
//     */
//    public function Create(Classroom $classroom) {
//        return $this->json([
//            'vasya' => '$id',
//        ]);
//    }
//
//    /**
//     * @Route("/classroom/{id}", name="update", methods={"PUT"})
//     * @param int $id
//     * @param Classroom $classroom
//     * @return JsonResponse
//     */
//    public function Update(int $id, Classroom $classroom) {
//        return $this->json([
//            'vasya' => '$id',
//        ]);
//    }

    /**
     * @Route("/classroom/{id}", name="delete", methods={"DELETE"})
     * @param int $id
     * @return JsonResponse
     */
    public function Delete(int $id) {
        return $this->json([
            'vasya' => '$id',
        ]);
    }
}
