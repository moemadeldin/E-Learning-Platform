<?php

declare(strict_types=1);

namespace App\Actions\Teacher\Section;

use App\Models\Section;

final class UpdateSectionAction
{
    public function execute(array $data, Section $section): Section
    {
        $section->update($data);

        return $section;
    }
}
