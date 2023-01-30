<?php

class PDOUtil
{
    public static function createPDO(RepositoryProperties $repositoryProperties) : PDO
    {
        try {
            return new PDO("$repositoryProperties->signature:
            host={$repositoryProperties->host};
            dbname={$repositoryProperties->database}",
                $repositoryProperties->user,
                $repositoryProperties->password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
        } catch (Exception $exception) {
            NetUtil::sendError(INTERNAL_SERVER_ERROR_CODE, 'Internal server error');
        }
    }
}