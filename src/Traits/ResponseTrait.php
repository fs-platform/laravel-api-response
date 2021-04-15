<?php

namespace Aron\Response\Traits;

use Symfony\Component\HttpFoundation\Response as FoundationResponse;
use \Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    use ResponseStatusTrait;


    /*
 |--------------------------------------------------------------------------
 | api 响应
 |--------------------------------------------------------------------------
 |api 响应格式说明
 |{
 |   "status":"",   必须返回，只能为 success 或者 error
 |   "code":"",     必须返回，应用返回的状态码，三位数的状态码和http状态码一致，自定义状态码从 1000 开始
 |   "message":"",  可选返回，作为请求成功 或者 失败的一个备注说明
 |   "data":"",     可选返回，请求成功需要返回数据时返回
 |   "errors":""    可选返回，请求失败返回的具体错误信息说明
 |}
 |
 */


    /**
     * @Notes: 失败信息返回
     *
     * @param int $code 状态码
     * @param array $headers
     * @param mixed $errors
     * @param string $message
     * @return JsonResponse
     * @author: Aron
     * @Date: 2021/3/17
     * @Time: 2:54 下午
     */
    public function failed(
        int $code = FoundationResponse::HTTP_BAD_REQUEST,
        string $message = '',
        array $errors = [],
        array $headers = []
    ): JsonResponse
    {
        return $this->response([], $code, self::$errorStatus, $message, $errors, $headers);
    }


    /**
     * @Notes: 资源未找到
     *
     * @param string $message
     * @return JsonResponse
     * @author: Aron
     * @Date: 2021/3/17
     * @Time: 3:36 下午
     */
    public function notFound($message = 'Not Found'): JsonResponse
    {
        return $this->failed(FoundationResponse::HTTP_NOT_FOUND, $message);
    }

    /**
     * @Notes: 服务器内部错误
     *
     * @param string $message
     * @return JsonResponse
     * @author: Aron
     * @Date: 2021/3/17
     * @Time: 3:35 下午
     */
    public function internalError($message = "Internal Error!"): JsonResponse
    {

        return $this->failed(FoundationResponse::HTTP_INTERNAL_SERVER_ERROR, $message);
    }


    /**
     * @Notes: 服务器理解请求客户端的请求，但是拒绝执行此请求
     *
     * @param $message
     * @return JsonResponse
     * @author: Aron
     * @Date: 2021/3/17
     * @Time: 3:43 下午
     */
    public function forbidden($message = '403 Forbidden'): JsonResponse
    {
        return $this->failed(FoundationResponse::HTTP_FORBIDDEN, $message);
    }

    /**
     * @Notes: 请求要求用户的身份认证
     *
     * @param string $message
     * @return JsonResponse
     * @author: Aron
     * @Date: 2021/3/17
     * @Time: 3:38 下午
     */
    public function unauthorized($message = ''): JsonResponse
    {
        return $this->failed(FoundationResponse::HTTP_UNAUTHORIZED, $message);
    }

    /**
     * @Notes: 服务器完成客户端的 PUT 请求时可能返回此代码，服务器处理请求时发生了冲突
     *
     * @param string $message
     * @return JsonResponse
     * @author: Aron
     * @Date: 2021/3/17
     * @Time: 3:42 下午
     */
    public function conflict($message = ''): JsonResponse
    {
        return $this->failed(FoundationResponse::HTTP_CONFLICT, $message);
    }

    /**
     * @Notes: 客户端请求的语法错误，服务器无法理解
     *
     * @param string $message
     * @return JsonResponse
     * @author: Aron
     * @Date: 2021/3/17
     * @Time: 3:45 下午
     */
    public function badRequest($message = ''): JsonResponse
    {
        return $this->failed(FoundationResponse::HTTP_BAD_REQUEST, $message);
    }

    /**
     * @Notes:客户端请求中的方法被禁止
     *
     * @param $message
     * @return JsonResponse
     * @author: Aron
     * @Date: 2021/3/17
     * @Time: 3:47 下午
     */
    public function notAllow($message = ''): JsonResponse
    {
        return $this->failed(FoundationResponse::HTTP_METHOD_NOT_ALLOWED, $message);
    }

    /**
     * @Notes: 请求格式正确，但是由于含有语义错误，无法响应
     *
     * @param array $errors
     * @param string $message
     * @return JsonResponse
     * @author: Aron
     * @Date: 2021/4/15
     * @Time: 11:50 上午
     */
    public function unprocessable(array $errors = [], string $message = ''): JsonResponse
    {
        return $this->failed(FoundationResponse::HTTP_UNPROCESSABLE_ENTITY, $message, $errors);
    }

    /**
     * @Notes:已创建。成功请求并创建了新的资源
     *
     * @return JsonResponse
     * @author: Aron
     * @Date: 2021/3/17
     * @Time: 4:07 下午
     */
    public function created(): JsonResponse
    {
        return $this->response();
    }


    /**
     * @Notes: 响应数据
     *
     * @param array $data
     * @param int $code
     * @param string $status
     * @param string $message
     * @param array $errors
     * @param array $headers
     * @return JsonResponse
     * @author: Aron
     * @Date: 2021/3/17
     * @Time: 4:24 下午
     */
    public function response(
        array $data = [],
        int $code = FoundationResponse::HTTP_OK,
        string $status = '',
        string $message = '',
        array $errors = [],
        array $headers = []
    ): JsonResponse
    {
        $status = $status ?: self::$successStatus;
        $data = $this->format($status, $code, $data, $message, $errors);
        return response()->json($data, $code, $headers);
    }


    /**
     * @Notes: 格式化数据返回信息
     *
     * @param array $data
     * @param int $status
     * @param int $code
     * @param string $message
     * @param mixed $errors
     * @return array
     * @author: Aron
     * @Date: 2021/3/17
     * @Time: 2:51 下午
     */
    protected function format(
        string $status = '',
        int $code = FoundationResponse::HTTP_OK,
        array $data = [],
        string $message = "",
        $errors = []
    ): array
    {
        $status = $status ?: self::$successStatus;
        return compact(
            'status',
            'code',
            'message',
            'data',
            'errors'
        );
    }
}
