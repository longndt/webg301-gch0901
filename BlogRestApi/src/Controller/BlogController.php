<?php

namespace App\Controller;

use App\Entity\Blog;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/blog/{id}', methods: 'GET', name: 'view_blog_by_id')]
    public function viewBlogById ($id) {
        //SELECT * FROM Blog WHERE id = '$id'
        $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
        //TH1: id không tồn tại
        if ($blog == null) {
            return new Response("Blog not found", Response::HTTP_NOT_FOUND);
        }
        //TH2: id có tồn tại
        else {
            $json = $this->serializerInterface->serialize($blog, 'json');
            return new Response($json, 200, 
                                [
                                    'content-type' => 'application/json'
                                ]);
        }        
    }

    #[Route('/blog/delete/{id}', methods: 'DELETE', name: 'delete_blog')]
    public function deleteBlog ($id) {
        try {
            //DELETE FROM Blog WHERE id = '$id'
            $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
            //TH1: id không tồn tại
            if ($blog == null) {
                return new Response("Blog not found");
            }
            //TH2: id có tồn tại
            else {
                $manager = $this->getDoctrine()->getManager();
                $manager->remove($blog);
                $manager->flush();
                //return new Response("Delete blog succeed !");
                return new Response(Response::HTTP_NO_CONTENT);
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return new Response($error, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/blog/add', methods: 'POST', name: 'add_new_blog')]
    public function addBlog (Request $request) {
        try {
            //tạo mới 1 object blog
            $blog = new Blog;
            //khai báo biến $data để lấy dữ liệu nhập vào
            $data = json_decode($request->getContent(),true);
            //set các trường dữ liệu cho object blog
            $blog->setAuthor($data['author']);
            $blog->setTitle($data['title']);
            $blog->setContent($data['content']);
            $blog->setDate(\DateTime::createFromFormat('Y-m-d',$data['date']));
            //gọi đến manager để đẩy dữ liệu của object vào database
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($blog);
            $manager->flush();
            return new Response("Add blog succeed !", Response::HTTP_CREATED);
        }
        catch (\Exception $e) {
            $error = $e->getMessage();
            return new Response($error, Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/blog/update/{id}', methods: 'PUT', name: 'update_blog')]
    public function updateBlog ($id, Request $request) {
        try{
            //gọi object blog lấy từ DB theo id
            $blog = $this->getDoctrine()->getRepository(Blog::class)->find($id);
            //TH1: id không tồn tại
            if ($blog == null) {
                return new Response("Blog not found");
            }
            //TH2: id có tồn tại
            else {
                //khai báo biến $data để lấy dữ liệu nhập vào
                $data = json_decode($request->getContent(), true);
                //set các trường dữ liệu cho object blog
                $blog->setAuthor($data['author']);
                $blog->setTitle($data['title']);
                $blog->setContent($data['content']);
                $blog->setDate(\DateTime::createFromFormat('Y-m-d', $data['date']));
                //gọi đến manager để đẩy dữ liệu của object vào database
                $manager = $this->getDoctrine()->getManager();
                $manager->persist($blog);
                $manager->flush();
                return new Response("Update blog succeed !", Response::HTTP_ACCEPTED);
            }
        }
        catch (\Exception $e) {
            $error = $e->getMessage();
            return new Response($error, Response::HTTP_BAD_REQUEST);
        }
    }
}
