<?php declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static Admin()
 * @method static static Agent()
 * @method static static progress()
 */
final class UserType extends Enum
{
    const Admin = 0;
    const Agent = 1;
    const Progress = 2;
}
