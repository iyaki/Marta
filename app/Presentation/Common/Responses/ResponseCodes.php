<?php

declare(strict_types=1);

namespace Marta\Presentation\Common\Responses;

enum ResponseCodes: int
{
    case OK = 200;
    case FOUND = 302;
    case NOT_FOUND = 404;
}
