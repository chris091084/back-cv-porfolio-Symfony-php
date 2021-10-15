<?php

namespace App\Controller;

use App\Entity\User;
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

        $dataRow = $request->getContent();
        $data = $serializer->deserialize($dataRow, User::class, 'json');
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return $this->json($data, 201);
    }
}
