<?php

namespace App\Library\Api;

/**
 * Class Error
 * @package App\Library\Api
 */
class Error 
{
    const RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND';
    const ACTION_FAILED = 'ACTION_FAILED';
    const AUTHENTICATION_FAILED = 'AUTHENTICATION_FAILED';
    const FIELD_EMPTY = 'FIELD_EMPTY';
    const FIELD_INVALID = 'FIELD_INVALID';
    const FIELD_REQUIRED = 'FIELD_REQUIRED';
    const PERMISSION_DENIED = 'PERMISSION_DENIED';

    public $errorCode;
    public $parameter;

    public static $customErrorCodes = [
        'ACTION_FAILED' => [
            'message' => 'The server failed to perform this action for unknown internal reason',
            'status' => 500
        ],

        'RESOURCE_NOT_FOUND' => [
            'message' => 'Resource does not exist or has been removed',
            'status' => 404
        ],

        'AUTHENTICATION_FAILED' => [
            "message" => "Used authentication credentials are invalid or signature verification failed",
            "status" => 401
        ],

        'FIELD_EMPTY' => [
            "message" => "The value of the field cannot be empty",
            "status" => 400
        ],

        'FIELD_INVALID' => [
            'message' => 'The value of the field is invalid',
            'status' => 400
        ],

        'FIELD_REQUIRED' => [
            'message' => 'This action requires the field to be specified',
            'status' => 400
        ],
        'PERMISSION_DENIED' => [
            'message' => 'You do not have access to perform this action',
            'status' => 403
        ]

        /*
         * @todo add more error codes
         */
    ];

    public function __construct($errorCode, $parameter = '') {
        if(!isset(self::$customErrorCodes[$errorCode])) {
            throw new \Exception('Invalid error code given');
        }

        $this->errorCode = $errorCode;
        $this->parameter = $parameter;
    }

    /**
     * Return error array
     * @return array
     */
    public function GetData() {
        return [
            'code' => $this->errorCode,
            'parameter' => $this->parameter,
            'message' => self::$customErrorCodes[$this->errorCode]['message']
        ];
    }
}