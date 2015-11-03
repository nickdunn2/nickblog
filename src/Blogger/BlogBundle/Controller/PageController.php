<?php
// src/Blogger/BlogBundle/Controller/PageController.php

namespace Blogger\BlogBundle\Controller;

use Blogger\BlogBundle\Entity\Enquiry;
use Blogger\BlogBundle\Form\EnquiryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render('BloggerBlogBundle:Page:index.html.twig');
    }

    public function aboutAction()
    {
        return $this->render('BloggerBlogBundle:Page:about.html.twig');
    }

    public function contactAction(Request $request)
    {
        // create an enquiry and give it some dummy data
        $enquiry = new Enquiry();

        $form = $this->createFormBuilder($enquiry)
            ->add('name', 'text')
            ->add('email', 'email')
            ->add('subject', 'text')
            ->add('body', 'textarea')
            ->add('save', 'submit', array('label' => 'Send'))
            ->getForm();

        $form->handleRequest($request);

        if($form->isValid()) {
            // perform some action, such as saving the enquiry to the database or sending the email

            return $this->redirectToRoute('enquiry_success');

        }

        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView(),
        ));

//        $form = $this->createFormBuilder(new EnquiryType(), $enquiry);
//
//        $request = $this->getRequest();
//        if($request->getMethod() == 'POST') {
//            $form->bindRequest($request);
//
//            if($form->isValid()) {
//                // Perform some action, such as sending an email
//
//                // Redirect - This is important to prevent users re-posting
//                // the form if they refresh the page
//
//                return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));
//            }
//        }
//
//
//        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
//            'form' => $form->createView()
//        ));
    }
}