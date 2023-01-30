<?php

use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class AuthController
{
    private static ?AuthController $instance = null;
    private Repository $repository;

    private function __construct(RepositoryProperties $repositoryProperties)
    {
        $this->repository = new Repository($repositoryProperties);
    }

    public static function getInstance(RepositoryProperties $repositoryProperties): AuthController
    {
        if (self::$instance === null) {
            self::$instance = new self($repositoryProperties);
        }
        return self::$instance;
    }

    public function getUsersCount(): ?array
    {
        return $this->repository->getUsersCount();
    }

    public function addUser(User $user): void
    {
        if ($user->username != '' || $user->password != '') {
            $user->password = password_hash($user->password, PASSWORD_DEFAULT);
            $this->repository->addUser($user);
        }
        NetUtil::sendError(BAD_REQUEST_ERROR_CODE,
            'Wrong register parameters');
    }

    public function login(User $user, JWTProperties $JWTProperties): array
    {
        $repoUser = $this->repository->getUser($user);
        if (!password_verify($user->password, $repoUser->password)) {
            NetUtil::sendError(BAD_REQUEST_ERROR_CODE,
                'Wrong login parameters');
        }

        return array("jwt" => AuthUtil::createJWT($repoUser, $JWTProperties));
    }

    public function checkJwt(string $jwt): array
    {
        try {
            $decodedJwt = JWT::decode($jwt, new Key(JWT_KEY, JWT_ALGORITHM));
            return array(
                "userData" => $decodedJwt->data
            );
        } catch (Exception $exception) {
            NetUtil::sendError(BAD_REQUEST_ERROR_CODE,
                'Wrong JWT');
        }
    }

    public function updateUser(User $user): array
    {
        if ($user->password != '') {
            $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        }

        $this->repository->updateUser($user);

        return array("jwt" => AuthUtil::createJWT($user,
            new JWTProperties(JWT_KEY, JWT_ISS,
                JWT_AUD, JWT_IAT, JWT_NBF)));
    }

    private function __clone()
    {
    }
}