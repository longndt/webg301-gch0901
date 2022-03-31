<?php

namespace App\Controller;

use App\Entity\Note;
use App\Form\NoteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NoteController extends AbstractController
{
    #[Route('/', name: 'note_index')]
    public function noteIndex() {
        $notes = $this->getDoctrine()->getRepository(Note::class)->findAll();
        return $this->render('note/index.html.twig', array
                            (
                                'notes' => $notes
                            ));
    }

    //Cách 1: tạo form trực tiếp trong controller (không recommend)
    #[Route('/new', name: 'note_new')]
    public function noteNew(Request $request) {
        //tạo object cho entity Note
        $note = new Note;
        //tạo form bằng form buidler
        //nội dung của form lấy từ attribute của entity (ngoại trừ id)
        $form = $this->createFormBuilder($note)
                     ->add('title', TextType::class)
                     ->add('content', TextType::class)
                     ->add('date', DateType::class,
                      [
                         'widget' => 'single_text'
                      ])
                     ->add('Add', SubmitType::class)
                     ->getForm();
        //handle request của form
        $form->handleRequest($request);
        //check xem form đã submit hay chưa và có hợp lệ hay không
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($note);
            $manager->flush();
            return $this->redirectToRoute('note_index');
            // return $this->render('note/success.html.twig',
            //                     [
            //                         'note' => $note
            //                     ]);
        }
        //render ra form để nhập liệu
        return $this->render('note/new.html.twig',
                            [
                                'noteForm' => $form->createView()
                            ]);            
    }

    //Cách 2: tạo file form riêng và gọi ra ở controller (recommend)
    #[Route('/add', name: 'note_add')]
    public function noteAdd (Request $request) {
        $note = new Note;
        //tạo form từ file form NoteType, dữ liệu được lưu vào $note
        $form = $this->createForm(NoteType::class, $note);
        //handle request của form
        $form->handleRequest($request);
        //check xem form đã submit hay chưa và có hợp lệ hay không
        if ($form->isSubmitted() && $form->isValid()) {
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($note);
            $manager->flush();
            return $this->redirectToRoute('note_index');
        }
        //render ra form để nhập liệu
        //Note: nếu dùng renderForm() thì không có createView()
        return $this->renderForm('note/add.html.twig',
                                [
                                    'noteForm' => $form
                                ]);   
    }
}
