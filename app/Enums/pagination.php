<?php

declare(strict_types=1);

namespace App\Enums;

enum Pagination: int
{
    case DEFAULT_PER_PAGE = 5;
    case USERS_PER_PAGE = 10;
    case COURSES_PER_PAGE = 6;
    case REVIEWS_PER_PAGE = 3;
    case TEACHER_REQUESTS_PER_PAGE = 15;
}
