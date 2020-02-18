<?php
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="Majstorce API",
 *     version="0.0.1"
 * )
 * @OA\Server(
 *     url="http://api.majstorce.mk/api/latest",
 *     description="Production Enviroment"
 * )
 * @OA\Server(
 *     url="http://api.majstorce.mk.local/api/latest",
 *     description="Local Enviroment - with host"
 * )
 * @OA\Server(
 *     url="http://localhost/api/latest",
 *     description="Local Enviroment -  docker"
 * )
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      in="header",
 *      name="Authorizati3on",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT"
 * )
 */
