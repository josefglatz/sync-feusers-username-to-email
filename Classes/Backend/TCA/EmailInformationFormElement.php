<?php
declare(strict_types=1);

namespace JosefGlatz\SyncFeUsersUsernameToEmail\Backend\TCA;

use TYPO3\CMS\Backend\Form\Element\AbstractFormElement;
use TYPO3\CMS\Core\Localization\LanguageService;

/**
 * Custom FieldInformation node to display helpful notices to the backend editor
 *
 * @author Josef Glatz <typo3@josefglatz.at>
 */
class EmailInformationFormElement extends AbstractFormElement
{

    /**
     * @inheritDoc
     */
    public function render()
    {
        $result = $this->initializeResultArray();
        $html = [];
        $html[] = '<div class="callout callout-info"><div class="media"><div class="media-body"><h4 class="callout-title">';
        $html[] = $this->translateString('LLL:EXT:sync_feusers_username_to_email/Resources/Private/Language/locallang_db.xlf:fieldInformation.username.title');
        $html[] = '</h4><div class="callout-body">';
        $html[] = '<ul>';
        if ($GLOBALS['TCA']['fe_users']['columns']['username']['config']['type'] === 'email') {
            $html[] = '<li>' . $this->translateString('LLL:EXT:sync_feusers_username_to_email/Resources/Private/Language/locallang_db.xlf:fieldInformation.username.info.validEmail') . '</li>';
        }
        if (str_contains($GLOBALS['TCA']['fe_users']['columns']['username']['config']['eval'], 'uniqueInPid')) {
            $html[] = '<li>' . $this->translateString('LLL:EXT:sync_feusers_username_to_email/Resources/Private/Language/locallang_db.xlf:fieldInformation.username.info.uniqueInPid') . '</li>';
        }
        $html[] = '</ul>';
        $html[] = '</div></div></div></div>';

        $result['html'] = implode('', $html);
        return $result;
    }

    private function translateString(string $input): string
    {
        return $this->getLanguageService()->sL($input);
    }

    protected function getLanguageService(): LanguageService
    {
        return $GLOBALS['LANG'];
    }
}
