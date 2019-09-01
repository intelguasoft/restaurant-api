<?php

namespace IntelGUA\FoodPoint\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
            return response()->json([
                'data' => [
                    'ok'        => false,
                    'message'   => 'Your token has expired',
                    'code'      => 401
                ]
            ], 401);
        } elseif ($exception instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
            return response()->json([
                'data' => [
                    'ok'        => false,
                    'message'   => 'Your token is invalid',
                    'code'      => 401
                ]
            ], 401);
        } elseif ($exception instanceof \Tymon\JWTAuth\Exceptions\JWTException) {
            return response()->json([
                'data' => [
                    'ok'        => false,
                    'message'   => 'The token was not sent',
                    'code'      => 401
                ]
            ], 401);
        }
        return parent::render($request, $exception);
    }
}
