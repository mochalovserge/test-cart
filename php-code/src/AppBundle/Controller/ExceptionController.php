<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Log\DebugLoggerInterface;

class ExceptionController
{
    /**
     * @param Request $request
     * @param $exception
     * @param DebugLoggerInterface|null $logger
     * @return array
     */
    public function showAction(Request $request, $exception, DebugLoggerInterface $logger = null)
    {
        return [
            'error' => [
                'type' => $this->getErrorType($exception),
                'message' => $exception->getMessage(),
            ],
        ];
    }

    /**
     * @param \Exception $exception
     * @return string
     */
    protected function getErrorType(\Exception $exception)
    {
        return 'error_type';
    }

    /**
     * Determines the status code to use for the response.
     *
     * @param \Exception $exception
     *
     * @return int
     */
    protected function getStatusCode(\Exception $exception)
    {

        // Otherwise, default
        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        return 500;
    }
}
