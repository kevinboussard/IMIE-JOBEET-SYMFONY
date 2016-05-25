<?php

namespace Jbt\KevinBoussardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Ajax controller.
 *
 */
class AjaxController extends Controller
{

    public function getResultSqlRequestAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest()) // On vérifie la présence d'une requete Ajax
        {
            $check = false;
            $sqlRequest = '';
            $sqlRequest = $request->get('sql_request');

            if ($sqlRequest != '')
            {
                $em = $this->getDoctrine()->getManager();
                $connection = $em->getConnection();

                $requeteType = substr($sqlRequest, 0, 6);

                if(strtolower($requeteType) == "select"){
                    $statement = $connection->prepare($sqlRequest);
                    $statement->execute();
                    $results = $statement->fetchAll();
                }else{
                    $results = $connection->executeUpdate($sqlRequest);
                }

                return new JsonResponse(array('result' => json_encode($results)));
            }else{
                return new JsonResponse(array('result' => json_encode('empty')));
            }

        }
        return new Response("Erreur lors de la requete Ajax",400);
    }
}
