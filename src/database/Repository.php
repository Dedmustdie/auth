<?php

require __DIR__ . '/../utils/RepositoryUtil.php';
require __DIR__ . '/../utils/PDOUtil.php';

class Repository
{
    private ?PDO $pdo;

    function __construct(RepositoryProperties $repositoryProperties)
    {
        try {
            $this->pdo = PDOUtil::createPDO($repositoryProperties);
        } catch (Exception $exception) {
            NetUtil::sendError(INTERNAL_SERVER_ERROR_CODE, 'Internal server error');
        }
    }

    function getUsersCount(): array
    {
        try {
            $res = $this->pdo->query('SELECT COUNT(*) FROM users');
            return ['count' => $res->fetchColumn()];
        } catch (Exception $exception) {
            NetUtil::sendError(INTERNAL_SERVER_ERROR_CODE, 'Internal server error');
        }
    }

    function addUser(User $user): void
    {
        try {
            $this->pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)")
                ->execute([
                    'username' => $user->username,
                    'password' => $user->password
                ]);
        } catch (PDOException $exception) {
            if ($exception->getCode() == CONFLICT_SQL_ERROR_CODE) {
                NetUtil::sendError(BAD_REQUEST_ERROR_CODE, 'User already exist');
            }
            NetUtil::sendError(INTERNAL_SERVER_ERROR_CODE, 'Internal server error');
        }
    }

    function getUser(User $user): User
    {
        try {
            $stmt = $this->pdo->prepare("SELECT id, username, password FROM users WHERE username = :username");
            $stmt->execute([
                'username' => $user->username
            ]);

            $res = $stmt->fetch();

            if ($res == null) {
                NetUtil::sendError(BAD_REQUEST_ERROR_CODE, 'User does not exist');
            }
            return new User($res['id'], $res['username'], $res['password']);
        } catch (Exception $exception) {
            NetUtil::sendError(INTERNAL_SERVER_ERROR_CODE, 'Internal server error');
        }
    }

    function updateUser(User $user): void
    {
        try {
            $setQuery = RepositoryUtil::createUpdateSetQuery($user);
            if ($setQuery == '') {
                NetUtil::sendError(BAD_REQUEST_ERROR_CODE, 'Empty fields');
            }
            $stmt = $this->pdo->prepare("UPDATE users SET $setQuery WHERE id = :id");

            $stmt->bindValue('id', $user->id);
            if ($user->username != '') {
                $stmt->bindValue('username', $user->username);
            }
            if ($user->password != '') {
                $stmt->bindValue('password', $user->password);
            }

            $stmt->execute();
        } catch (Exception $exception) {
            NetUtil::sendError(INTERNAL_SERVER_ERROR_CODE, 'Internal server error');
        }
    }
}