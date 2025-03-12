<?php

namespace App\Response;

use App\DTO\ErrorResponseContent;
use Nelmio\ApiDocBundle\Attribute\Model;
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
                ref: new Model(type: ErrorResponseContent::class),
            ),
        );
    }
}
