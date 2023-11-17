<?php
declare(strict_types=1);

namespace JosefGlatz\SyncFeUsersUsernameToEmail\Helper;

/**
 * Class StringHelper
 * @package JosefGlatz\SyncFeUsersUsernameToEmail\Helper
 * @author Josef Glatz <typo3@josefglatz.at>
 */
class StringHelper
{
    public static function removeStringInList(array &$fields, string $fieldName): void
    {
        array_splice(
            $fields,
            self::findFieldVariantInList($fieldName, $fields),
            1
        );

        ArrayHelper::resetKeys($fields);
    }


    public static function stringStartsWith(string $string, string $startsWith): bool
    {
        return strpos($string, $startsWith) === 0;
    }

    public static function removeLabelFromFieldName(string $fieldName): string
    {
        $fieldNameWithoutLabel = '';
        if (PositionHelper::fieldHasLabel($fieldName)) {
            [$fieldNameWithoutLabel,] = ArrayHelper::trimExplode(';', $fieldName);
        }

        return $fieldNameWithoutLabel ?: $fieldName;
    }

    public static function findFieldVariantInList(string $fieldName, array $fields): ?int
    {
        $pattern = '/' . $fieldName . '(;\w+)?/';
        $matches = preg_grep($pattern, $fields);
        debug($matches);

        return array_key_first($matches);
    }
}

