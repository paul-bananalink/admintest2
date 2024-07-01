<?php

namespace App\GraphQL;

use App\Exceptions\GraphQLException;
use Exception;
use GraphQL\Error\Error;
use Rebing\GraphQL\Error\ValidationError;

class ErrorFormatterGraphQL
{
    public function __construct()
    {
    }

    /**
     * Format error
     * [
     * errors => [
     *     message => [field1 => 'field chet vi du lieu khong hop le',
     *     field1 => 'field chet vi du lieu khong hop le',
     *     field1 => 'field chet vi du lieu khong hop le',]
     *    locations => [],
     * ]
     */
    public static function formatError(Error $e): array
    {
        // return $e->getPrevious()->getValidatorMessages()->getMessages();
        return [
            'message' => $e->getMessage(),
            'locations' => $e->getLocations(),
            'path' => $e->getPath(),
        ];
    }

    /**
     * Custom handle errors
     *
     * @param [type] $errors
     */
    public static function handleErrors($errors, callable $formatter): array
    {
        $formattedErrors = [];
        foreach ($errors as $error) {
            $previousError = $error->getPrevious();
            $formattedError['message'] = $error->getMessage();
            if ($previousError instanceof ValidationError) {
                $formattedError['validations'] = $previousError->getValidatorMessages()->getMessages();
            } elseif ($previousError instanceof GraphQLException) {
                // $formattedError['message'] = 'Error type variable or structor graphql';
            } elseif ($previousError instanceof Exception) {
                // $formattedError['message'] = 'Error type variable or structor graphql';
            } else {
                $formattedError['message'] = env('APP_DEBUG') ? $error->getMessage() : 'Server error';
                $formattedError['trace'] = $previousError ? $previousError->getTrace() : null;
            }
            array_push($formattedErrors, $formattedError);
        }

        return $formattedErrors;
    }
}
