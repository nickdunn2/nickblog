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
            $message = \Swift_Message::newInstance()
                ->setSubject('Contact enquiry from nickblog')
                ->setFrom('enquiries@nickblog.vm')
                ->setTo('nickdunnblog@gmail.com')
                ->setBody($this->renderView('BloggerBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
            $this->get('mailer')->send($message);

            // $this->get('session')->setFlash('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');

            // Redirect - This is important to prevent users re-posting
            // the form if they refresh the page
            return $this->redirect($this->generateUrl('BloggerBlogBundle_contact'));

        }

        return $this->render('BloggerBlogBundle:Page:contact.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}