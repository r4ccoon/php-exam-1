<?php

namespace Rpl\Framework\Middleware;

use Firebase\JWT\JWT;
use Klein\Exceptions\HttpException;
use Klein\Request;
use Klein\Response;

class JwtValidatorMiddleware implements MiddlewareInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @param ReturnObjectInterface $returnObject
     * @param RequestAttributeSet|null $attributeSet
     * @return Response|null
     */
    public function run(
        Request $request,
        Response $response,
        ReturnObjectInterface $returnObject = null,
        RequestAttributeSet $attributeSet = null
    ): ?Response {
        $jwtDecoded = $this->isValid();

        if (!$jwtDecoded) {
            throw new HttpException("invalid jwt", 400);

        } else {
            $attributeSet->set("user", $jwtDecoded);
        }

        return null;
    }

    private function isValid()
    {
        $key = getenv("JWT_SECRET");
        $jwt = $this->getBearerToken();

        try {
            $decoded = JWT::decode($jwt, $key, array('HS256'));

            return $decoded;
        } catch (\Exception $exception) {
            // invalid jwt
            return false;
        }
    }

    /**
     * Get header Authorization
     * */
    private function getAuthorizationHeader(): string
    {
        $headers = "";

        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } else {
            if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
                $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
            } elseif (function_exists('apache_request_headers')) {
                $requestHeaders = apache_request_headers();
                // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
                $requestHeaders = array_combine(
                    array_map('ucwords', array_keys($requestHeaders)),
                    array_values($requestHeaders)
                );

                if (isset($requestHeaders['Authorization'])) {
                    $headers = trim($requestHeaders['Authorization']);
                }
            }
        }

        return $headers;
    }

    /**
     * get access token from header
     * */
    private function getBearerToken(): string
    {
        $headers = $this->getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }

        return '';
    }
}