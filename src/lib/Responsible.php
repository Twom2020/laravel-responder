<?php
/**
 * Created by AliGhaleyan - AlirezaSajedi
 */

namespace Twom\Responder\lib;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response as Res;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

/**
 * Trait Responsible
 *
 * @package App\Http\Traits
 */
trait Responsible
{
    /**
     * @var $statusCode int
     */
    protected $statusCode = null;

    /**
     * @var string
     */
    protected $message = null;
    /**
     * @var array|null
     */
    protected $data = null;
    /**
     * @var array|string|null
     */
    protected $error = null;


    /**
     * @param array $data
     * @return ResponseFactory|Res
     */
    public function respond(array $data = [])
    {
        $default = [
            "status_code" => $this->getStatusCode() ?? Res::HTTP_OK,
            "status"      => "success",
        ];

        if (!is_null($this->getMessage()))
            $data['message'] = $this->getMessage();
        else
            $data['message'] = $data['message'] ?? trans("responder::messages.success");

        if (!is_null($this->getRespondData())) {
            if (isset($data['data']) && $data['data'] && is_array($data['data'])) {
                $data['data'] = array_merge($data['data'], $this->getRespondData());
            } else {
                $data['data'] = $this->getRespondData();
            }
        }

        if (!is_null($this->getRespondError()))
            $data['errors'] = $this->getRespondError();

        $data = array_replace($default, $data);

        return \response($data, $data['status_code']);
    }


    /**
     * @param      $message
     * @param null $mode
     *
     * @return Responsible
     */
    public function setMessage($message, $mode = null)
    {
        if (is_null($mode))
            $this->message = $message;
        else
            $this->message = trans("responder::messages.{$mode}", ["attribute" => $message]);
        return $this;
    }

    /**
     * set data for respond ['data' => $data]
     *
     * @param $data
     * @return $this
     */
    public function setRespondData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * appendData
     *
     * @param array $data
     * @return $this
     */
    public function appendRespondData(array $data)
    {
        $this->setRespondData(array_merge((array)$this->getRespondData(), $data));
        return $this;
    }

    /**
     * set data for response ['error' => $error | (string) or (array)]
     *
     * @param $error
     * @return $this
     */
    public function setRespondError($error)
    {
        $this->error = $error;
        return $this;
    }

    /**
     * get data of sending respond
     *
     * @return array|null
     */
    public function getRespondData()
    {
        return $this->data;
    }

    /**
     * get error of sending respond
     *
     * @return array|null
     */
    public function getRespondError()
    {
        return $this->error;
    }


    /**
     * @return null
     */
    public function getMessage()
    {
        return $this->message;
    }


    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }


    /**
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }


    /**
     * @param null $data
     *
     * @return ResponseFactory|Res
     */
    public function respondCreated($data = null)
    {
        return $this->respond([
            "status_code" => Res::HTTP_CREATED,
            "data"        => $data,
        ]);
    }


    /**
     * @param null $data
     *
     * @return ResponseFactory|Res
     */
    public function respondUpdated($data = null)
    {
        return $this->respond([
            "data" => $data,
        ]);
    }


    /**
     * @return ResponseFactory|Res
     */
    public function respondDeleted()
    {
        return $this->respond();
    }


    /**
     * @param array $data
     *
     * @return ResponseFactory|Res
     */
    public function respondBadRequest()
    {
        return $this->respond([
            "status"      => "error",
            "status_code" => Res::HTTP_BAD_REQUEST,
            "message"     => trans("responder::messages.error"),
        ]);
    }


    /**
     * @return ResponseFactory|Res
     */
    public function respondNotFound()
    {
        is_null($this->getMessage()) ?
            $this->setMessage(trans("responder::messages.notfound"))
            : $this->getMessage();
        return $this->respond([
            'status'      => 'error',
            'status_code' => Res::HTTP_NOT_FOUND,
        ]);
    }


    /**
     * @return ResponseFactory|Res
     */
    public function respondInternalError()
    {
        is_null($this->getMessage()) ?
            $this->setMessage(trans("responder::messages.internal_error"))
            : $this->getMessage();
        return $this->respond([
            'status'      => 'error',
            'status_code' => Res::HTTP_INTERNAL_SERVER_ERROR,
        ]);
    }


    /**
     * @param array $errors
     *
     * @return ResponseFactory|Res
     */
    public function respondValidationError($errors = [])
    {
        is_null($this->getMessage()) ?
            $this->setMessage(trans("responder::messages.validation_error"))
            : $this->getMessage();
        return $this->respond([
            'status'      => 'error',
            'status_code' => Res::HTTP_UNPROCESSABLE_ENTITY,
            'errors'      => $errors,
        ]);
    }


    /**
     * @param array $data
     *
     * @return ResponseFactory|Res
     */
    public function respondUnauthorizedError()
    {
        return $this->respond([
            "status"      => "error",
            "status_code" => Res::HTTP_UNAUTHORIZED,
        ]);
    }


    /**
     * @param Paginator $paginate
     * @param           $data
     *
     * @return ResponseFactory|Res
     */
    public function respondWithPagination(Paginator $paginate, $data)
    {
        return $this->respond([
            'data'      => $data,
            'paginator' => [
                'total_count'  => $paginate->total(),
                'total_pages'  => ceil($paginate->total() / $paginate->perPage()),
                'current_page' => $paginate->currentPage(),
                'limit'        => $paginate->perPage(),
            ],
        ]);
    }
}
