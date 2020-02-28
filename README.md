## Laravel Responder
### Installation:
```
composer require twom/laravel-responder
```

You must add the service provider to `config/app.php` for load lang
```php
'providers' => [
	 // for laravel 5.8 and below
	 \Twom\Responder\ResponderServiceProvider::class,
];
```

### The response schema:
```json
{
	"status": "success or error",
	"status_code": 200, //	or 422, 400, 500, ...
	"message": "your setted message",
	"data": "your data",
	"errors": "your errors" // like validation error
}
```
> **Note:** support of **fa** and **en** languages.

### Respond types:
| method                    | description                                                       |
|---------------------------|-------------------------------------------------------------------|
|`respond(array $data = [])`| default is successfully respond. merge `$data` with default schema|
|`respondValidationError($errors = [])`| validation error code 422                              |
|`respondCreated($data = null)`| created code 201. you can set data from this method input  |
|`respondUpdated($data = null)`| updated code 200. you can set data from this method input |
|`respondDeleted()`        | deleted successfully response with code 200 						|
|`respondBadRequest()`     | response bad request error code 400 |
|`respondNotFound()`       | response not found page error code 404|
|`respondInternalError()`  | response internal error code 500									 |
|`respondUnauthorizedError()`| response unauthorize error code 401 								 |

### Setters methods:
| method   			| description							 |
|-------------------|----------------------------------------|
|`setStatusCode($statusCode)`|	set the `status_code` in default schema|
|`setMessage($message, $mode = null)`| set the `message` in default schema. the `$mode` parameter can be `created|updated|deleted`, like this: `setMessage("user", "created")` so the message is `user created.`|
|`setRespondData($data)`| set the `data` in default schema 										 |
|`appendRespondData($data)`| append the `data` in default schema|
|`setRespondError($error)`| set the `errors` in default schema|




### Example:
> **Note:** you must use of this facade.
```php
use Twom\Responder\Facade\Responder; // use of this
```
#### normal respond:
```php
return Responder::respond();
```
output:
```json
{
    "status_code": 200,
    "status": "success",
    "message": "operation successfully!" // in en language
}
```
> **Note:** default mode is successfully operation.

#### Custom respond:
```php
return Responder::respond([  
  "status" => "my status",  
  "status_code"=> 300,  
  "message" => "custom message",  
]);
```
output:
```json
{
    "status_code": 300,
    "status": "my status",
    "message": "custom message"
}
```

#### Validation error respond:
```php
return Responder::respondValidationError([  
  'title' => [  
	  'the title field is required.', // ...another errors  
  ], // ... another fields  
]);
```
output:
```json
{
    "status_code": 422,
    "status": "error",
    "errors": {
        "title": [
            "the title field is required."
        ]
    },
    "message": "validation error!"
}
```

#### Created respond:
```php
return Responder::respondCreated();
//	or  
return Responder::respondCreated("the created object");
```
output:
```json
{
    "status_code": 201,
    "status": "success",
    "data": "the created object", // or null
    "message": "operation successfully!"
}
```

#### Bad request respond:
```php
return Responder::respondBadRequest();
```
output:
```json
{
    "status_code": 400,
    "status": "error",
    "message": "operation has error!"
}
```

#### Use setters:
```php
return Responder::setMessage("test message")  
	 ->setRespondData(["the data"])  
	 ->setRespondError(["title"=> ["errors"]])  
	 ->setStatusCode(203)  
	 ->respond();
```
output:
```json
{
    "status_code": 203,
    "status": "success",
    "message": "test message",
    "data": [
        "the data"
    ],
    "errors": {
        "title": [
            "errors"
        ]
    }
}
```
