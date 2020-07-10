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

use App\Entity\User as User;
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

class UserService extends AppService {
    public $entityRepo;
    public $encoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $encoder) {
        parent::__construct($entityManager);
        $this->entityRepo =  $entityManager->getRepository("App:User");
        $this->encoder =  $encoder;
    }
    
    
    public function new( $parms) { 

        $name = parms('_name');
        $email = parms('_email');
        $username = parms('_username');
        $password = parms('_password');            
        // CHEQUEO SI EXISTE EL USERNAME
        if( $this->entityRepo->findBy([ "username" => $username ]) != [])
            throw new Exception( $username .' no esta disponible, intente con otro!');
            
        $user = new User();
        $user->setName($name);
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setPlainPassword($password);
        $user->setPassword($this->encoder->encodePassword($user, $password));

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function edit( $parms) { 
        
        $user = $parms['user'];
        $name = $parms['_name'];
        $email = $parms['_email'];
        $username = $parms['_username'];
        $password = $parms['_password'];
        //compara si el usuario que se quiere editar es el que esta logueado
        if ( $user->getId() != $parms['logged_user']->getId() ){
            throw new Exception( 'Acceso denegado!');
        }
        if (!is_null($username)) {
            // verificamos que el username nuevo no exista
            $existe = $this->entityRepo->findOneBy([ "username" => $username ]);
            if( isset($existe) and $existe->getId() != $user->getId() )
                throw new Exception( $username .' no esta disponible, intente con otro!');
            $user->setUsername($username);
        }
        if (!is_null($name)){
            $user->setName($name);
        }
        if (!is_null($email)) {
            $user->setEmail($email);
        }
        if (!is_null($password)) {
            //habria que verificar con la pass vieja
             $user->setPassword($this->encoder->encodePassword($user, $password));
        }

        $this->em->persist($user);
        $this->em->flush();
        
        return $user;
    }


}