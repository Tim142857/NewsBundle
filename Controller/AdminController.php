<?php

namespace Tleroch\NewsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminController extends Controller {

    /**
     * List all News
     * @return type
     */
    public function listingAction(Request $request) {
        if (!$this->get('tleroch_admin.security')->verify()) {
            return $this->redirect($request->getBaseUrl());
        }

        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository($this->getParameter('tleroch_news.news_class'))->findAllWithLocale($this->getParameter('locale'));

        return $this->render('NewsBundle:admin:list.html.twig', array(
                    'news' => $news
        ));
    }

    /**
     * Add one news
     * @param Request $request
     * 
     * @return Response
     */
    public function addAction(Request $request) {
        if (!$this->get('tleroch_admin.security')->verify()) {
            return $this->redirect($request->getBaseUrl());
        }

        $classNews = $this->getParameter('tleroch_news.news_class');
        $news = new $classNews();

        $formFactory = $this->get('tleroch.news.form_factory');

        $form = $formFactory->createForm();
        $form->setData($news);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if (!is_null($news->getImage()) && $news->getImage() instanceof File) {
                    $news->setImage($news->getImage()->getFilename());
                }

                if (!is_null($news->getFile()) && $news->getFile() instanceof File) {
                    $news->setFile($news->getFile()->getFilename());
                }

                $em = $this->getDoctrine()->getManager();

                $em->persist($news);
                $em->flush();

                $this->get('session')->getFlashBag()->add('news', 'Votre actualité a bien été ajoutée.');

                return $this->redirectToRoute('tleroch_news_admin');
            }
        }

        return $this->render('NewsBundle:Admin:add.html.twig', array(
                    'form' => $form->createView()
        ));
    }

    /**
     * Edit one news
     * 
     * @param int $id
     * @param Request $request
     * 
     * @return Response
     */
    public function editAction($id, Request $request) {
        if (!$this->get('tleroch_admin.security')->verify()) {
            return $this->redirect($request->getBaseUrl());
        }

        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository($this->getParameter('tleroch_news.news_class'))->find($id);

        $formFactory = $this->get('tleroch.news.form_factory');

        $form = $formFactory->createForm();
        $form->setData($news);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!is_null($news->getImage()) && $news->getImage() instanceof File) {
                $news->setImage($news->getImage()->getFilename());
            }

            if (!is_null($news->getFile()) && $news->getFile() instanceof File) {
                $news->setFile($news->getFile()->getFilename());
            }

            $em->flush();

            $this->get('session')->getFlashBag()->add('news', 'Votre actualité a bien été modifiée.');

            return $this->redirectToRoute('tleroch_news_admin');
        }

        return $this->render('NewsBundle:Admin:edit.html.twig', array(
                    'news' => $news,
                    'form' => $form->createView()
        ));
    }

    /**
     * Delete one news
     * 
     * @param int $id
     * @param Request $request
     * 
     * @return Response
     */
    public function deleteAction($id, Request $request) {
        if (!$this->get('tleroch_admin.security')->verify()) {
            return $this->redirect($request->getBaseUrl());
        }

        $em = $this->getDoctrine()->getManager();

        $news = $em->getRepository($this->getParameter('tleroch_news.news_class'))->find($id);

        $form = $this->createFormBuilder()
                ->add('submit', SubmitType::class)
                ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Delete files
            if (!is_null($news->getImage())) {
                $image = $this->get('kernel')->getRootDir() . '/../web/' . $this->getParameter('tleroch_news.upload_folder') . $news->getImage();

                if (file_exists($image) && is_file($image)) {
                    unlink($image);
                }
            }

            if (!is_null($news->getFile())) {
                $file = $this->get('kernel')->getRootDir() . '/../web/' . $this->getParameter('tleroch_news.upload_folder') . $news->getFile();

                if (file_exists($file) && is_file($file)) {
                    unlink($file);
                }
            }

            $em->remove($news);
            $em->flush();

            $this->get('session')->getFlashBag()->add('news', 'Votre actualité a bien été supprimée.');

            return $this->redirectToRoute('tleroch_news_admin');
        }

        return $this->render('NewsBundle:Admin:delete.html.twig', array(
                    'news' => $news,
                    'form' => $form->createView()
        ));
    }

    /**
     * 
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadAction(Request $request) {
        if (!$this->get('tleroch_admin.security')->verify()) {
            return new JsonResponse(array(
                'success' => false,
                'message' => 'Invalid rights'
            ));
        }

        if (empty($request->files)) {
            return new JsonResponse(array(
                'success' => false,
                'message' => 'Missing parameter'
            ));
        }

        $file = $request->files->get('file');

        try {
            $uploaded = $this->get('tleroch_admin.file_uploader')->upload($this->getParameter('tleroch_news.upload_folder'), $file);
        } catch (FileException $e) {
            return new JsonResponse(array(
                'success' => false,
                'message' => $e->getMessage()
            ));
        }

        return new JsonResponse(array(
            'success' => true,
            'file' => $uploaded->getFilename(),
            'url' => $this->get('router')->getContext()->getBaseUrl() . '/../' . $this->getParameter('tleroch_news.upload_folder') . $uploaded->getFilename(),
            'mimetype' => $uploaded->getMimeType()
        ));
    }

}
