<?php

namespace App\DBAL\Type;

use App\DBAL\EnumType;

class TaskStatus extends EnumType
{
    const CREATED = 'CREATED';
    const IN_PROGRESS = 'IN_PROGRESS';
    const DONE = 'DONE';

    const CREATED_VALUE = 'Created';
    const IN_PROGRESS_VALUE = 'In_progress';
    const DONE_VALUE = 'Done';

    protected $name = 'AppealStatus';

    protected static $choices = [
        self::CREATED => self::CREATED_VALUE,
        self::IN_PROGRESS => self::IN_PROGRESS_VALUE,
        self::DONE => self::DONE,
    ];
}
