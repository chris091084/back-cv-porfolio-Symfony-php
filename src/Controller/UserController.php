<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user', methods:"POST")]
    public function NewUser (Request $request, SerializerInterface $serializer): Response
    {
        //$normalizers = [new ObjectNormalizer()];
        //$serializer = new Serializer($normalizers);

        $dataRow = $request->getContent();

        $data = $serializer->deserialize($dataRow, User::class, 'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return $this->json($data, 201);
    }

    #[Route('/users', name: 'getUsers', methods:"GET")]
    public function GetUsers (UserRepository $userRepository,SerializerInterface $serializer ){
        $data= $userRepository->findAll();
        return $this->json($data,200);
    }
}
