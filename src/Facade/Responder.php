<?php
/**
 * Created by AliGhaleyan - AlirezaSajedi
 */

namespace Twom\Responder\Facade;


use Illuminate\Support\Facades\Facade;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

/**
 * Class Responder
 * @package Twom\Responder\Facade
 *
 * @method static respond(array $data = [])
 * @method static \Twom\Responder\lib\Responder setMessage($message, $mode = null)
 * @method static \Twom\Responder\lib\Responder setRespondData($data)
 * @method static \Twom\Responder\lib\Responder appendRespondData($data)
 * @method static \Twom\Responder\lib\Responder setRespondError($error)
 * @method static getRespondData()
 * @method static getRespondError()
 * @method static getMessage()
 * @method static getStatusCode()
 * @method static \Twom\Responder\lib\Responder setStatusCode($statusCode)
 * @method static respondCreated($data = null)
 * @method static respondUpdated($data = null)
 * @method static respondDeleted()
 * @method static respondBadRequest()
 * @method static respondNotFound()
 * @method static respondInternalError()
 * @method static respondValidationError($errors = [])
 * @method static respondUnAuthorizedError()
 * @method static respondWithPagination(Paginator $paginate, $data)
 */
class Responder extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Twom\Responder\lib\Responder::class;
    }
}
