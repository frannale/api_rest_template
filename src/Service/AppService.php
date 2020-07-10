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

namespace App\Service;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Doctrine\ORM\EntityManagerInterface; 

class AppService{
    public $em;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->em =  $entityManager;
    }

    public function all( $request){
 
        return $this->entityRepo->findAll();
    }

    public function show( $entity){
 
        return $entity;
    }

    public function delete( $entity){
        //habria que verificar
        $this->em->remove($entity);
        $this->em->flush();
        return $entity;
    }


}