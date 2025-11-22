<?php

declare(strict_types=1);

namespace App\Actions\Teacher\Section;

use App\Models\Section;

final class DeleteSectionAction
{
    public function execute(Section $section): void
    {
        $section->delete();
    }
}
