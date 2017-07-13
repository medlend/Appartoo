<?php

/**
 * Created by Ounis Mokhtar
 * Date 28/09/2016
 */

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Custom ExceptionController that uses the view layer and supports HTTP response status code mapping.
 */
class ExceptionController
{

    /**
     * Custom exceprions display
     *
     * @param Request $request
     * @param \Exception $exception
     * @return JsonResponse
     */
    public function showAction(Request $request, $exception)
    {
        return new JsonResponse(['errors' => $exception->getMessage(), 'status_code' => method_exists($exception, 'getStatusCode')?$exception->getStatusCode():500], method_exists($exception, 'getStatusCode')?$exception->getStatusCode():500);
    }

}
