<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @Route("/api", name="api_")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/posts", name="post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();

        $data = [];

        foreach ($posts as $post) {
            $data[] = [
                'id' => $post->getId(),
                'title' => $post->getTitle(),
                'creationDate' => $post->getCreationDate(),
                'content' => $post->getContent(),
                'author' => $post->getAuthor()->getUsername()
            ];
        }

        return $this->json($data);
    }

    /**
     * @Route("/posts", name="post_new", methods={"POST"})
     */
    public function new(Request $request,
                        UserRepository $userRepository,
                        EntityManagerInterface $entityManager,
                        TokenStorageInterface $tokenStorage,
                        JWTTokenManagerInterface $tokenManager): Response
    {

        $jwt = $tokenManager->decode($tokenStorage->getToken());
        $post = new Post();
        $post->setTitle($request->request->get('title'));
        $post->setAuthor($userRepository->findOneByEmail($jwt['username']));
        $post->setContent($request->request->get('content'));
        $post->setCreationDate(new \DateTime());


        $entityManager->persist($post);
        $entityManager->flush();

        return $this->json('Created new post successfully with id ' . $post->getId());
    }

    /**
     * @Route("/posts/{id}", name="post_show", methods={"GET"})
     */
    public function show(int $id, PostRepository $postRepository): Response
    {
        $post = $postRepository->find($id);

        if (!$post) {

            return $this->json('No insult found for id' . $id, 404);
        }

        $data =  [
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'creationDate' => $post->getCreationDate(),
            'content' => $post->getContent(),
            'author' => $post->getAuthor()->getUsername()
        ];

        return $this->json($data);
    }

    /**
     * @Route("/posts/{id}", name="post_edit", methods={"PUT"})
     */
    public function edit(Request $request,
                         int $id,
                         EntityManagerInterface $entityManager): Response
    {
        $post = $entityManager->getRepository(Post::class)->find($id);

        if (!$post) {
            return $this->json('No post found for id' . $id, 404);
        }

        $post->setTitle($request->request->get('title'));
        $post->setContent($request->request->get('content'));
        $entityManager->flush();

        $data =  [
            'id' => $post->getId(),
            'title' => $post->getTitle(),
            'creationDate' => $post->getCreationDate(),
            'content' => $post->getContent(),
            'author' => $post->getAuthor()->getUsername()
        ];

        return $this->json($data);
    }

    /**
     * @Route("/posts/{id}", name="post_delete", methods={"DELETE"})
     */
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $post = $entityManager->getRepository(Post::class)->find($id);

        if (!$post) {
            return $this->json('No post found for id' . $id, 404);
        }

        $entityManager->remove($post);
        $entityManager->flush();

        return $this->json('Deleted a post successfully with id ' . $id);
    }
}
