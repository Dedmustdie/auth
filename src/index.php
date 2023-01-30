<?php

require __DIR__ . '/config.php';
require __DIR__ . '/const/constants.php';
require __DIR__ . '/utils/NetUtil.php';
require __DIR__ . '/database/Repository.php';
require __DIR__ . '/utils/RoutesUtil.php';
require __DIR__ . '/utils/AuthUtil.php';
require __DIR__ . '/service/AuthController.php';
require __DIR__ . '/model/RepositoryProperties.php';
require __DIR__ . '/model/JWTProperties.php';
require __DIR__ . '/model/User.php';
include VENDOR_PATH . '/vendor/autoload.php';

header('Content-type: application/json; charset=utf-8');

$authController = AuthController::getInstance(new RepositoryProperties(
    REPOSITORY_SIGNATURE, REPOSITORY_HOST,
    REPOSITORY_DATABASE, REPOSITORY_USER,
    REPOSITORY_PASSWORD));

RoutesUtil::route(GET_COUNT_PATTERN, function () use ($authController) {
    echo json_encode($authController->getUsersCount(), JSON_UNESCAPED_UNICODE);
});

RoutesUtil::route(ADD_USER_PATTERN, function () use ($authController) {
    $postData = json_decode(file_get_contents('php://input'), true);
    $authController->addUser(new User('', $postData['username'] ?? '',
        $postData['password'] ?? ''));
});

RoutesUtil::route(LOGIN_PATTERN, function () use ($authController) {
    $postData = json_decode(file_get_contents('php://input'), true);
    echo json_encode($authController->login(new User('', $postData['username'] ?? '',
        $postData['password'] ?? ''),
        new JWTProperties(JWT_KEY, JWT_ISS, JWT_AUD, JWT_IAT, JWT_NBF)));
});

RoutesUtil::route(JWT_CHECK_PATTERN, function () use ($authController) {
    $postData = json_decode(file_get_contents('php://input'), true);
    echo json_encode($authController->checkJwt($postData['jwt'] ?? ''));
});

RoutesUtil::route(UPDATE_USER_PATTERN, function () use ($authController) {
    $postData = json_decode(file_get_contents('php://input'), true);
    echo json_encode($authController->updateUser(new User($postData['id'] ?? '',
        $postData['username'] ?? '', $postData['password'] ?? '')));
});

RoutesUtil::execute();
