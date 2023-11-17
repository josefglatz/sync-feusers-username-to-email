<?php
declare(strict_types=1);

namespace JosefGlatz\SyncFeUsersUsernameToEmail\Helper;

/**
 * Class ArrayHelper
 * @package JosefGlatz\SyncFeUsersUsernameToEmail\Helper
 * @author Josef Glatz <typo3@josefglatz.at>
 */
class ArrayHelper
{
    public static function resetKeys(array &$fields)
    {
        $fields = array_values($fields);
    }

    public static function trimExplode(string $delim, ?string $string): array
    {
        $result = explode($delim, $string);

        return array_map('trim', $result);
    }
}
