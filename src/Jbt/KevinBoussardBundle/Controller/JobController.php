<?php

namespace Jbt\KevinBoussardBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Jbt\KevinBoussardBundle\Entity\Job;
use Jbt\KevinBoussardBundle\Form\JobType;

/**
 * Job controller.
 *
 */
class JobController extends Controller
{
    /**
     * Lists all Job entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('JbtKevinBoussardBundle:Category')->getWithJobs();

        foreach($categories as $category)
        {
            $category->setActiveJobs($em->getRepository('JbtKevinBoussardBundle:Job')->getActiveJobs($category->getId(), $this->container->getParameter('max_jobs_on_homepage')));
            $category->setMoreJobs($em->getRepository('JbtKevinBoussardBundle:Job')->countActiveJobs($category->getId()) - $this->container->getParameter('max_jobs_on_homepage'));
        }

        return $this->render('JbtKevinBoussardBundle:Job:index.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * Creates a new Job entity.
     *
     */
    public function newAction(Request $request)
    {
        $job = new Job();
        $job->setType('full-time');
        $form = $this->createForm('Jbt\KevinBoussardBundle\Form\JobType', $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($job);
            $em->flush();

            return $this->redirect($this->generateUrl('jbt_job_preview', array(
                'company' => $job->getCompanySlug(),
                'location' => $job->getLocationSlug(),
                'token' => $job->getToken(),
                'position' => $job->getPositionSlug()
            )));
        }

        return $this->render('JbtKevinBoussardBundle:Job:new.html.twig', array(
            'job' => $job,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Job entity.
     *
     */
    public function showAction(Job $job)
    {
        $deleteForm = $this->createDeleteForm($job->getToken());
        $em = $this->getDoctrine()->getManager();

        $job = $em->getRepository('JbtKevinBoussardBundle:Job')->getActiveJob($job->getId());

        if (!$job) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        return $this->render('JbtKevinBoussardBundle:Job:show.html.twig', array(
            'job' => $job,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Finds and displays a Job entity preview.
     *
     */
    public function previewAction($token)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $job = $em->getRepository('JbtKevinBoussardBundle:Job')->findOneByToken($token);

        if (!$job) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $deleteForm = $this->createDeleteForm($job->getToken());
        $publishForm = $this->createPublishForm($job->getToken());

        return $this->render('JbtKevinBoussardBundle:Job:show.html.twig', array(
            'job'      => $job,
            'delete_form' => $deleteForm->createView(),
            'publish_form' => $publishForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Job entity.
     *
     */
    public function editAction(Request $request, $token)
    {
        $em = $this->getDoctrine()->getManager();
        $job = $em->getRepository('JbtKevinBoussardBundle:Job')->findOneByToken($token);

        if (!$job) {
            throw $this->createNotFoundException('Unable to find Job entity.');
        }

        $deleteForm = $this->createDeleteForm($token);
        $editForm = $this->createForm('Jbt\KevinBoussardBundle\Form\JobType', $job);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($job);
            $em->flush();

            return $this->redirect($this->generateUrl('jbt_job_preview', array(
                'company' => $job->getCompanySlug(),
                'location' => $job->getLocationSlug(),
                'token' => $job->getToken(),
                'position' => $job->getPositionSlug()
            )));
        }

        return $this->render('JbtKevinBoussardBundle:Job:edit.html.twig', array(
            'job' => $job,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Publish a Job entity.
     *
     */
    public function publishAction(Request $request, $token)
    {
        $form = $this->createPublishForm($token);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('JbtKevinBoussardBundle:Job')->findOneByToken($token);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Job entity.');
            }

            $entity->publish();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->set('notice', 'Your job is now online for 30 days.');
        }

        return $this->redirect($this->generateUrl('jbt_job_preview', array(
            'company' => $entity->getCompanySlug(),
            'location' => $entity->getLocationSlug(),
            'token' => $entity->getToken(),
            'position' => $entity->getPositionSlug()
        )));
    }

    /**
     * Deletes a Job entity.
     *
     */
    public function deleteAction(Request $request, $token)
    {
        $form = $this->createDeleteForm($token);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $job = $em->getRepository('EnsJobeetBundle:Job')->findOneByToken($token);

            if (!$job) {
                throw $this->createNotFoundException('Unable to find Job entity.');
            }

            $em->remove($job);
            $em->flush();
        }

        return $this->redirectToRoute('jbt_job_index');
    }

    /**
     * Creates a form to delete a Job entity.
     *
     * @param Job $job The Job entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($token)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jbt_job_delete', array('token' => $token)))
            ->add('token', 'hidden')
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    private function createPublishForm($token)
    {
        return $this->createFormBuilder(array('token' => $token))
            ->add('token', 'hidden')
            ->getForm()
            ;
    }

}
