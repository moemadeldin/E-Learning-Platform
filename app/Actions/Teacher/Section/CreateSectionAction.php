<?php

declare(strict_types=1);

namespace App\Actions\Teacher\Section;

use App\Models\Course;
use App\Models\Section;

final class CreateSectionAction
{
    public function execute(array $data, Course $course): Section
    {
        $section = $course->sections()->create($data);

        return $section;
    }
}
