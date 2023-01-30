<?php

const NOT_FOUND_CODE = 404;
const SUCCESS_CODE = 200;
const INTERNAL_SERVER_ERROR_CODE = 500;
const BAD_REQUEST_ERROR_CODE = 400;
const UNAUTHORIZED_ERROR_CODE = 401;
const CONFLICT_SQL_ERROR_CODE = 23505;

const LOGIN_PATTERN = '/auth/login';
const ADD_USER_PATTERN = '/auth/add';
const GET_COUNT_PATTERN = '/auth/count';
const JWT_CHECK_PATTERN = '/auth/jwt';
const UPDATE_USER_PATTERN = '/auth/update';