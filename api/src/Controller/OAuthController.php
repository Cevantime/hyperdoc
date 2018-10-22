<?php
/**
 * Created by PhpStorm.
 * User: cevantime
 * Date: 14/10/18
 * Time: 20:34
 */

namespace App\Controller;

use App\Entity\User;
use App\Repository\AccessTokenRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\RequestTypes\AuthorizationRequest;
use League\Plates\Engine;
use Middlewares\Utils\Traits\HasResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sherpa\Controller\AppController;
use Sherpa\Plates\Traits\RendererTrait;
use Sherpa\Traits\RouteTrait;
use Zend\Diactoros\Response;
use Zend\Diactoros\Stream;

class OAuthController extends AppController
{
    use RendererTrait;
    use RouteTrait;
    use HasResponseFactory;

    public function authorize(ServerRequestInterface $request, AuthorizationServer $server, UserRepository $userRepo)
    {
        $response = new Response();
        try {
            if (!isset($_SESSION['user'])) {
                $this->validateRequest($request, $server);
                return $this->redirectToRoute('login');
            }

            if(!isset($_SESSION['auth_request'])) {
                $this->validateRequest($request, $server);
            }

            /** @var AuthorizationRequest $authRequest */
            $authRequest = $_SESSION['auth_request'];
            $user = $userRepo->find($_SESSION['user']);

            if(!$user) {
                unset($_SESSION['user']);
                return $this->redirectToRoute('login');
            }

            $authRequest->setUser($user);
            // At this point you should redirect the user to an authorization page.
            // This form will ask the user to approve the client and the scopes requested.

            // Once the user has approved or denied the client update the status
            // (true = approved, false = denied)
            $authRequest->setAuthorizationApproved(true);

            // Return the HTTP redirect response
            return $server->completeAuthorizationRequest($authRequest, $response);
        } catch (OAuthServerException $exception) {
            // All instances of OAuthServerException can be formatted into a HTTP response
            return $exception->generateHttpResponse($response);

        } catch (\Exception $exception) {
            return $this->createResponse(500, $exception->getMessage());
        }
    }

    public function login(ServerRequestInterface $request, UserRepository $userRepo)
    {
        $error = null;
        $lastUsername = '';
        if($request->getMethod() === 'POST') {
            $post = $request->getParsedBody();
            if ( ! empty($post['username']) && ! empty($post['password'])) {
                $lastUsername = $post['username'];
                $user = $userRepo->getUserByUsername($lastUsername);
                if ($user && password_verify($post['password'], $user->getPassword())) {
                    $_SESSION['user'] = $user->getId();
                    return $this->redirectToRoute('authorize');
                } else {
                    $error = "Invalid credentials.";
                }
            } else {
                $error = 'Both username and password are required.';
            }
        }

        return $this->render('login', [
            'error' => $error,
            'lastUsername' => $lastUsername
        ]);
    }

    public function register(ServerRequestInterface $request, UserRepository $userRepo, EntityManagerInterface $em)
    {
        $errors = [];
        $data = [];
        if ($request->getMethod() === 'POST') {
            extract($data = $request->getParsedBody());
            foreach (['Username' => 'username', 'Email' => 'email', 'Password' => 'password'] as $label => $field) {
                if (empty($$field)) {
                    $errors[$field][] = sprintf('%s field is required', $label);
                }
            }

            if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'][] = sprintf('%s is not a valid email', $email);
            }

            foreach (['email', 'username'] as $field) {
                if (!empty($$field) && ($userRepo->findOneBy([$field => $$field]))) {
                    $errors[$field][] = sprintf('%s already exists in database', $$field);
                }
            }

            if (!$errors) {
                /** @var string $username */
                /** @var string $password */
                $user = (new User())
                    ->setUsername($username)
                    ->setPassword(password_hash($password, PASSWORD_ARGON2I))
                    ->setEmail($email);
                $em->persist($user);
                $em->flush();
                return $this->redirectToRoute('login');
            }
        }

        return $this->render('register', ['data' => $data, 'errors' => $errors]);
    }

    public function accessToken(ServerRequestInterface $request, AuthorizationServer $server)
    {
        $response = new Response();
        try {
            // Try to respond to the request
            return $server->respondToAccessTokenRequest($request, $response);
        } catch (OAuthServerException $exception) {
            // All instances of OAuthServerException can be formatted into a HTTP response
            return $exception->generateHttpResponse($response);
        } catch (\Exception $exception) {
            return $this->createResponse(500, $exception->getMessage());
        }
    }

    public function validateRequest(ServerRequestInterface $request, AuthorizationServer $server)
    {
        // Validate the HTTP request and return an AuthorizationRequest object.
        $authRequest = $server->validateAuthorizationRequest($request);
        $_SESSION['auth_request'] = $authRequest;
    }
}