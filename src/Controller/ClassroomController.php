<?php

namespace App\Controller;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use DateTime;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ClassroomController extends AbstractController
{
    /**
     * @var ClassroomRepository
     */
    private $classroomRepository;

    /**
     * @var ObjectManager
     */
    private $entityManager;

    /**
     * @var ValidatorInterface
     */
    private $validator;

    public function __construct(EntityManagerInterface $entityManager, ValidatorInterface $validator)
    {
        $this->classroomRepository = $entityManager->getRepository(Classroom::class);
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    /**
     * @Route("/", name="classroom")
     * @return JsonResponse
     */
    public function index()
    {
        return $this->json([
            'projectName' => 'Classroom API',
            'version' => '1.0.1',
        ]);
    }

    /**
     * @Route("/classrooms", name="get_all", methods={"GET"})
     * @param int $page
     * @param int $perPage
     * @return JsonResponse
     */
    public function GetAll(int $page = 0, int $perPage = 10) {
        $classrooms = $this->classroomRepository->findBy(
            [],
            ['id' => 'ASC'],
            $perPage,
            ($page * $perPage)
        );
        $totalClassrooms = $this->classroomRepository->count([]);

        return $this->json([
            'data' => $classrooms,
            'total' => $totalClassrooms,
        ]);
    }

    /**
     * @Route("/classroom/{id}", name="get_one", methods={"GET"})
     * @param Classroom $classroom
     * @return JsonResponse
     */
    public function GetOne(Classroom $classroom) {
        return $this->json($classroom);
    }

    /**
     * @Route("/classroom", name="create", methods={"POST"})
     * @param Request $request
     * @return JsonResponse|Response
     * @throws Exception
     */
    public function Create(Request $request) {


        $classroom = new Classroom();
        $classroom->assign(get_object_vars(json_decode($request->getContent())));
        $classroom->setCreatedAt(new DateTime());

        // Validation
        $errors = $this->validator->validate($classroom);

        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }
        // Saving
        $this->entityManager->persist($classroom);
        $this->entityManager->flush();

        return $this->json(get_object_vars($classroom));
    }

    /**
     * @Route("/classroom/{id}", name="update", methods={"PUT"})
     * @param int $id
     * @param Request $request
     * @return JsonResponse|Response
     */
    public function Update(int $id, Request $request) {

        /**
         * @var Classroom $classroom
         */
        $classroom = $this->classroomRepository->find($id);

        if (!$classroom) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $classroom->assign(get_object_vars(json_decode($request->getContent())));

        // Validation
        $errors = $this->validator->validate($classroom);
        if (count($errors) > 0) {
            return new Response((string) $errors, 400);
        }

        $this->entityManager->flush();

        return $this->json(get_object_vars($classroom));
    }

    /**
     * @Route("/classroom/{id}", name="delete", methods={"DELETE"})
     * @param Classroom $classroom
     * @return JsonResponse
     */
    public function Delete(Classroom $classroom) {
        $this->entityManager->remove($classroom);
        $this->entityManager->flush();

        return $this->json([
            'message' => "Classroom deleted: " . $classroom->getName(),
        ]);
    }
}

