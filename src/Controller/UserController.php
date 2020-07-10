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

use App\Entity\User as User;
use App\Service\UserService as userService;
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

/**
 * Class UserController
 *
 * @Route("/api")
 */
class UserController extends AppController {
    private $userService;
    
    public function __construct(userService $userService) {
        $this->userService = $userService;
    }   

    // USER URI's
    /*  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */ 
    /**
     * @Rest\Post("/login_check", name="user_login_check")
     *
     * @SWG\Response(
     *     response=200,
     *     description="User was logged in successfully"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="User was not logged in successfully"
     * )
     *
     * @SWG\Parameter(
     *     name="_username",
     *     in="body",
     *     type="string",
     *     description="The username",
     *     schema={
     *     }
     * )
     *
     * @SWG\Parameter(
     *     name="_password",
     *     in="body",
     *     type="string",
     *     description="The password",
     *     schema={}
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function getLoginCheckAction() {}


    /*  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */ 
    /**
     * @Rest\Post("/register", name="user_register")
     *
     * @SWG\Response(
     *     response=201,
     *     description="User was successfully registered"
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="User was not successfully registered"
     * )
     *
     * @SWG\Parameter(
     *     name="_name",
     *     in="body",
     *     type="string",
     *     description="The username",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_email",
     *     in="body",
     *     type="string",
     *     description="The username",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_username",
     *     in="body",
     *     type="string",
     *     description="The username",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_password",
     *     in="query",
     *     type="string",
     *     description="The password"
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function registerAction(Request $request){

        $parms = $request->request->all();
        return $this->ejecutarContenido([$this->userService, 'new'],$parms);
    }

    
    /*  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */ 
    /**
     * @Rest\Get("/v1/myself", name="myself_user", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Informacion del usuario logueado."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al consultar el usuario logueado."
     * )
     *
     *
     * @SWG\Tag(name="User")
     */
    public function myself(Request $request) {

        return $this->ejecutarContenido([$this->userService, 'show'],$this->getUser());
    }

    /*  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */ 
    /**
     * @Rest\Get("/v1/users/{id}.{_format}", name="user_id", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Se retorno el usuario exitosamente."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="No se encontro al usuario ."
     * )
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="ID del usuario "
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function show(User $user )  {

        return $this->ejecutarContenido([$this->userService, 'show'],$user);
    }

    /*  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */ 
    /**
     * @Rest\Get("/v1/users", name="all_user", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Informacion de los usuarioa."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="Error al consultar usuarios."
     * )
     *
     *
     * @SWG\Tag(name="User")
     */
    public function all(Request $request) {
       
        $parms = $request->request->all();
        return $this->ejecutarContenido([$this->userService, 'all'],$parms);
    }

	
	 /**
     * @Rest\Put("/v1/users/{id}", name="user_edit", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="The board was edited successfully."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="An error has occurred trying to edit the board."
     * )
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="ID"
     * )
     
     * @SWG\Parameter(
     *     name="_name",
     *     in="body",
     *     type="string",
     *     description="The username",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_email",
     *     in="body",
     *     type="string",
     *     description="The username",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_username",
     *     in="body",
     *     type="string",
     *     description="The username",
     *     schema={}
     * )
     *
     * @SWG\Parameter(
     *     name="_password",
     *     in="query",
     *     type="string",
     *     description="The password"
     * )
     * @SWG\Tag(name="User")
     */
	public function edit(Request $request, User $user) {
        
        $parms = $request->request->all();
        $parms['user'] = $user;
        $parms['logged_user'] = $this->getUser();
        return $this->ejecutarContenido([$this->userService, 'edit'],$parms);
    }
    
    /*  - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  */ 
    /**
     * @Rest\Delete("/v1/users/{id}.{_format}", name="user_id", defaults={"_format":"json"})
     *
     * @SWG\Response(
     *     response=200,
     *     description="Se retorno el usuario exitosamente."
     * )
     *
     * @SWG\Response(
     *     response=500,
     *     description="No se encontro al usuario ."
     * )
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="ID del usuario "
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function delete(User $user )  {

        return $this->ejecutarContenido([$this->userService, 'delete'],$user);
    }

}