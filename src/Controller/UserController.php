<?php

namespace App\Controller;

use App\Entity\User;
use App\Exception\RessourceValidationException;
use App\Exception\ValidationObjectException;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user', methods:"POST")]
    public function NewUser (Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManager $em): Response
    {
        $dataRow = $request->getContent();
        $data = $serializer->deserialize($dataRow, User::class, 'json');
        $violations =$validator->validate($data);

        try{
            $em->persist($data);
            $em->flush();
            return $this->json($data, 201);
        }catch (Exception $e) {
            throw new ValidationObjectException($violations,$e->getCode());
        }
    }

    #[Route('/users', name: 'getUsers', methods:"GET")]
    public function GetUsers (UserRepository $userRepository,SerializerInterface $serializer ){
        $data= $userRepository->findAll();
        return $this->json($data,200);
    }
}
