<?php

namespace App\Library\Api;
use Carbon\Carbon;
use Psy\Util\Str;

/**
 * Class Transformer
 */
class Response
{
    const LIMIT = 12;
    
    /* Response data related attributes */
    public $resourceName;
    public $method;
    public $status;
    public $data;

    /* Paginated attributes */
    public $totalCount;
    public $limit;
    public $offset;
    public $paginated = false;

    /**
     * Transformer constructor.
     * @param string $method
     * @param string $resourceName
     * @param int $statusCode
     * @param array $data (OPTIONAL)
     */
    public function __construct($method, $resourceName, $statusCode, $data = [])
    {
        $this->method = $method;
        $this->resourceName = $resourceName;
        $this->status = $statusCode;
        $this->data = $data;
    }

    /**
     * Set the paginated response format
     *
     * @param int $totalCount
     * @param int $limit
     * @param int $offset
     *
     * @return self
     */
    public function SetPaginated($totalCount, $limit, $offset)
    {
        $this->paginated = true;
        $this->totalCount = $totalCount;
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
    }

    /**
     * Dispatch error
     *
     * @param array $Errors
     * @throws \Exception
     * @return string
     */
    public function Error(array $Errors) {
        $data['status'] = $this->status;
        foreach ($Errors as $Error) {
            if(!$Error instanceof Error) {
                throw new \Exception('Invalid object given');
            }

            $data['errors'][] = $Error->GetData();
        }

        return $data;
    }

    /**
     * Dispatch result to browser
     * @param array $data
     *
     * @return string
     */
    public function Success($data = []) {
        return $this->Build($data);
    }

    /**
     * Build the response
     * @param array $data
     *
     * @return array
     */
    private function Build($data) {
        $output['status'] = $this->status;

        if($this->method != 'PUT' || $this->method != 'DELETE') {
            $output['data'] = $data;
            $output['resource'] = $this->resourceName;
        }

        if($this->paginated && $this->method == 'GET') {
            $output['offset'] = $this->offset;
            $output['limit'] = $this->limit;
            $output['total_count'] = $this->totalCount;
        }

        return $output;
    }
}