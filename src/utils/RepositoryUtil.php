<?php

class RepositoryUtil
{
    public static function createUpdateSetQuery(User $user): string
    {
        $query = '';
        if ($user->username  != '') {
            $query .= 'username = :username';
            if ($user->password  != '') {
                $query .= ', password = :password';
            }
        } else if ($user->password != '') {
            $query .= 'password = :password';
        }
        return $query;
    }
}