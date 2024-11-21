<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Resources\Json\JsonResource;

class ApiResponse extends JsonResource
{
    private $status;
    private $message;
    private $data;

    /**
     * Create a new API response instance.
     *
     * @param  string  $status
     * @param  string  $message
     * @param  mixed  $data
     * @return void
     */
    public function __construct(string $status, string $message, $data = null)
    {
        parent::__construct($data);
        $this->status = $status;
        $this->message = $message;
        $this->data = $data;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }

    /**
     * Create a success response.
     *
     * @param  string  $message
     * @param  mixed  $data
     * @return static
     */
    public static function success(string $message, $data = null): self
    {
        return new static('success', $message, $data);
    }

    /**
     * Create a fail response.
     *
     * @param  string  $message
     * @param  mixed  $data
     * @return static
     */
    public static function fail(string $message, $data = null): self
    {
        return new static('fail', $message, $data);
    }

    /**
     * Create an error response.
     *
     * @param  string  $message
     * @param  mixed  $data
     * @return static
     */
    public static function error(string $message, $data = null): self
    {
        return new static('error', $message, $data);
    }
}
