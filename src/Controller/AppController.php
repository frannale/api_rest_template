<?php
/**
 * ApiController.php
 *
 * API Controller
 *
* @category   Controller
 * @package    Reintegra
 * @author     Reintegra Team
 * @copyright  2020 open source
 * @license    http://www.php.net/license/3_0.txt  PHP License 3.0
 */

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AppController extends FOSRestController{

    public function debug( $data){
        $serializer = $this->get('jms_serializer');
        return $serializer->serialize($data, "json");
    }

    protected function jsonPost() {
        $rest_json = file_get_contents("php://input");
        return json_decode($rest_json, true);
    }


    public function jsonResponse($code,$data){

        $serializer = $this->get('jms_serializer');
        $response = [
            'code' => $code,
            'error' => $code < 400 ? false : true,
            'data' => $data,
        ];

    return new Response($serializer->serialize($response, "json"));
    }

    public function ejecutarContenido($functionName,$parametros){

        $em = $this->getDoctrine()->getManager();
        $result = [];
        $error = false;
        $message = "";
        $code = 200;
        
        try {
            
            $result = call_user_func_array($functionName, array($parametros));;

        } catch (Exception $ex) {
            $code = 500;
            $error = true;
            $message = " {$ex->getMessage()}";
        }

        return $this->jsonResponse($code, ($error == true) ? $message :  $result);
    }


}