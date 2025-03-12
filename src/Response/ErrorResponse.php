<?php

namespace App\Response;

use Symfony\Component\HttpFoundation\Response;
use OpenApi\Attributes as OA;

#[\Attribute(\Attribute::TARGET_CLASS | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class ErrorResponse extends OA\Response
{
    public function __construct()
    {
        parent::__construct(
            response: Response::HTTP_UNPROCESSABLE_ENTITY,
            description: 'Returns validation errors',
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'type', type: 'string'),
                    new OA\Property(property: 'title', type: 'string'),
                    new OA\Property(property: 'detail', type: 'string'),
                    new OA\Property(property: 'violations', type: 'array', items: new OA\Items(type: 'object')),
                ]
            )
        );
    }
}
