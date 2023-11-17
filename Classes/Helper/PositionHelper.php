<?php
declare(strict_types=1);

namespace JosefGlatz\SyncFeUsersUsernameToEmail\Helper;

/**
 * Class PositionHelper
 * @package JosefGlatz\SyncFeUsersUsernameToEmail\Helper
 * @author Josef Glatz <typo3@josefglatz.at>
 */
class PositionHelper
{
    public static function addFieldToPosition(array &$fields, string $fieldName, string $position = '')
    {
        if ($position === '') {
            $fields[] = $fieldName;
            return;
        }

        [$direction,] = ArrayHelper::trimExplode(':', $position);
        $fieldNameToSearch = str_replace($direction . ':', '', $position);
        $key = array_search($fieldNameToSearch, $fields, true);
        if ($key === false) {
            $fieldNameToSearchWithoutLabel = StringHelper::removeLabelFromFieldName($fieldNameToSearch);
            $shortenedFields = [];
            foreach ($fields as $key => $field) {
                $shortenedFields[$key] = StringHelper::removeLabelFromFieldName($field);
            }
            $key = array_search($fieldNameToSearchWithoutLabel, $shortenedFields, true);
        }
        if ($key !== false) {
            switch ($direction) {
                case 'before':
                    array_splice($fields, $key, 0, $fieldName);
                    break;
                case 'replace':
                    array_splice($fields, $key, 1, $fieldName);
                    break;
                case 'after':
                    array_splice($fields, ++$key, 0, $fieldName);
                    break;
                default:
            }
        }
        ArrayHelper::resetKeys($fields);
    }

}
