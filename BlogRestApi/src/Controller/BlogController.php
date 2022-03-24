<?php

namespace App\Controller;

use App\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class BlogController extends AbstractController
{
    private $serializerInterface;
    public function __construct(SerializerInterface $serializerInterface)
    {
        $this->serializerInterface = $serializerInterface;
    }

    /**
     * @Route("/blog", methods = {"GET"}, name = "view_all_blog_api")
     */
    public function viewAllBlog () {
        //lấy dữ liệu từ bảng Blog trong database
        //SELECT * FROM Blog
        $blogs = $this->getDoctrine()->getRepository(Blog::class)->findAll();
        //export dữ liệu từ bảng ra API (json hoặc xml)
        $json = $this->serializerInterface->serialize($blogs,'json');
        $xml = $this->serializerInterface->serialize($blogs,'xml');
        //return response với API theo định đạng mong muốn
        return new Response($json, Response::HTTP_OK,
                            [
                                'content-type' => 'application/json'
                            ]);
    }

    #Route['/blog/{id}', methods: 'GET', name: 'view_blog_by_id']
    public function viewBlogById ($id) {

    }
}
