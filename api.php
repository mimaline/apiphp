<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');

date_default_timezone_set('America/Maceio');

use \Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once "lib/slim/autoload.php";
require_once("core/Utils.php");

require_once("controllers/ControllerApiBase.php");
require_once("controllers/ControllerApiUsuario.php");
require_once("controllers/ControllerApiPessoa.php");

class Routes
{

    public function __construct()
    {
        $this->runApp();
    }

    /**
     * Executa o app para realizar a chamada de rotas
     *
     * @throws Throwable
     */
    protected function runApp()
    {
        $app = new \Slim\App($this->getConfigurationContainer());
        
        $app->add(function ($req, $res, $next) {
            $response = $next($req, $res);
            return $response
                // ->withHeader('Access-Control-Allow-Origin', 'https://atividades-senac-gelvazio.vercel.app')
                // Aceita todas as origens
                ->withHeader('Access-Control-Allow-Origin', '*')
                // Aceita somente os atributos headers desta lista abaixo
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, apikey')
                // Aceita apenas os metodos abaixo
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE');
        });
        
        // Agrupando rotas para adicionar o middleware em todas as rotas de uma só vez
        $app->group('', function () use ($app) {
            // Pagina inicial da api
            $app->get('/', ControllerApiBase::class . ':home');

            // Ping
            $app->get('/ping', ControllerApiBase::class . ':callPing');
            
            // Rotas de testes
            $app->get('/test', ControllerApiBase::class . ':test');
            $app->put('/test', ControllerApiBase::class . ':test');
            $app->post('/test', ControllerApiBase::class . ':test');
            $app->delete('/test', ControllerApiBase::class . ':test');

            // Cadastros - Usuarios
            $app->get('/users', ControllerApiUsuario::class . ':getUsuario');
            $app->post('/users', ControllerApiUsuario::class . ':gravaUsuario');
            $app->delete('/users', ControllerApiUsuario::class . ':deleteUsuario');
            $app->post('/login', ControllerApiUsuario::class . ':loginUsuario');
            $app->put('/updatepassword', ControllerApiUsuario::class . ':updatePassword');
            
            //$app->get('/logintest', ControllerApiUsuario::class . ':loginUsuario');

            // Pessoas
            $app->get('/pessoa', ControllerApiPessoa::class . ':getPessoa');
            $app->post('/pessoa', ControllerApiPessoa::class . ':savePessoa');
            $app->delete('/pessoa', ControllerApiPessoa::class . ':deletePessoa');
            
            // Fornecedor
            // $app->post('/fornecedor', ControllerApiPessoa::class . ':getFornecedor');
            $app->post('/fornecedor', ControllerApiPessoa::class . ':savePessoa');
            
        })->add($this->getMiddlewares());

        $app->run();
    }

    /**
     * Retorna a configuração das rotas
     *
     * @return \Slim\Container
     */
    private function getConfigurationContainer()
    {
        // Configuração de erros
        $configuration = [
            'settings' => [
                'displayErrorDetails' => true,
                'determineRouteBeforeAppMiddleware' => true,
            ],
        ];
        $configurationContainer = new \Slim\Container($configuration);

        return $configurationContainer;
    }

    /**
     * Retorna os midlewares de validação de rotas
     *
     * @return Closure
     */
    private function getMiddlewares()
    {
        // Middlewares
        $Middlware = function (Request $request, Response $response, $next) {
            
            $headers = $request->getHeaders();
            
            if(isset($headers["HTTP_APIKEY"]) && is_array($headers["HTTP_APIKEY"])){
                $token = $headers["HTTP_APIKEY"][0];
                if (trim($token) == "") {
                    $data = array("message" => "Acesso inválido - TOKEN - Envio:" . $token);
                    return $response->withJson($data, 401);
                }
            
                // Verifica se esse token de usuario existe
                if (!Routes::isValidTokenUsuario($token)) {
                    $data = array("message" => "Token inválido", "token informado:" => $token);
                    return $response->withJson($data, 401);
                }
    
                if(isset($headers["HTTP_X_API_KEY_SYSTEM"]) && is_array($headers["HTTP_X_API_KEY_SYSTEM"])) {
                    $token_sistema = $headers["HTTP_X_API_KEY_SYSTEM"][0];
    
                    // Verifica se esse token de sistema e valido
                    if (!Routes::isValidTokenApiSistema($token_sistema)) {
                    
                        $data = array("message" => "Token Sistema inválido", "token sistema informado:" => $token_sistema);
                    
                        return $response->withJson($data, 401);
                    }
                } else {
                    $data = array("message" => "Token Sistema não informado!");
                    
                    return $response->withJson($data, 401);
                }
            } else {
                $data = array("message" => "Token inválido!");
                return $response->withJson($data, 401);
            }

            $response = $next($request, $response);

            return $response;
        };

        return $Middlware;
    }
  
    public static function isValidTokenUsuario($token) {
        require_once("core/Query.php");
        $oQuery = new Query();
        
        $aDados = $oQuery->select("select usutoken as token
                                     from tbusuario
                                    where tbusuario.usutoken = '$token'
                                      and coalesce(tbusuario.usuativo, 0) = 1");
        
        if (!$aDados) {
            return false;
        }
        
        return true;
    }
    
    public static function isValidTokenApiSistema($token) {
        require_once("core/Query.php");
        $oQuery = new Query();
        
        $aDados = $oQuery->select("select sistokenapi as token
                                     from tbsistema
                                    where tbsistema.sistokenapi = '$token'
                                      and coalesce(tbsistema.sisativo, 0) = 1");
        
        if (!$aDados) {
            return false;
        }
        
        $token_api = Routes::getTokenApi();
        
        $token_sistema = $aDados["token"];
        
        if ($token_api === $token_sistema) {
            return true;
        }
        
        return false;
    }
    
    private static function getTokenApi() {
        return 'BE406D16ABFB8AB03A6AC07C25EBFA9E0D05DB778E0E679F214A13180530D46E1E62D206D4DF7FF8397B18DEFBE3847334809E314AAD2607E15DE7F9597CC990';
    }
}

$routes = new Routes();
