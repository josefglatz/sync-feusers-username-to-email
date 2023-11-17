..  include:: /Includes.rst.txt
..  _configuration-tsconfig-reference:

TSconfig reference
==================

Enable / disable some options
-----------------------------

..  note::

    #. The options are meant to be set in the Page TSconfig context.

    #. All options needs to be set as a child element of the root element
       :typoscript:`tx_sync_feusers_username_to_email.`

.. tip::

    Unless otherwise specified, all examples contain alternative values to the
    default settings configured by the extension.

..  confval:: enableEmailInformation

    :type: bool
    :Default: true

    If :php:`TRUE`, the informational info texts are shown above the field
    `username` when editing a website user (`fe_users` record)


    Example::

       # Hide element
       tx_sync_feusers_username_to_email {
          enableEmailInformation = 0
       }



..  confval:: showEmailFieldForNewRecord

    :type: bool
    :Default: false

    If :php:`TRUE`, the field `email` is shown in the backend editing form for a
    new `fe_users` record


    Example::

       # Show element
       tx_sync_feusers_username_to_email {
          showEmailFieldForNewRecord = 1
       }



..  confval:: setEmailFieldToReadOnly

    :type: bool
    :Default: true

    If :php:`TRUE`, the field `email` is set to `readOnly` for editors in the
    TYPO3 backend

    Example::

       # Do not set element to readOnly
       tx_sync_feusers_username_to_email {
          setEmailFieldToReadOnly = 0
       }



..  confval:: executeSyncViaDataHandlerHookOnCopyPaste

    :type: bool
    :Default: true

    If :php:`TRUE`, the field `email` is synced with the value of the field
    `username` when someone pastes a copy of an existing website user record via
    DataHandler

    Example::

       # Do not set execute sync on DataHandler paste
       tx_sync_feusers_username_to_email {
          executeSyncViaDataHandlerHookOnCopyPaste = 0
       }



..  confval:: executeSyncViaDataHandlerHook

    :type: bool
    :Default: true

    If :php:`TRUE`, the field `email` is synced with the value of the field
    `username` before the DataHandler persists a record

    Example::

       # Do not execute any sync of fields via DataHandler
       tx_sync_feusers_username_to_email {
          executeSyncViaDataHandlerHook = 0
       }



..  confval:: showPlaceholderForUsernameField

    :type: bool
    :Default: true

    If :php:`TRUE`, the field `username` is extended by the placeholder TCA
    option

    Example::

       # Disable the placeholder
       tx_sync_feusers_username_to_email {
          showPlaceholderForUsernameField = 0
       }


----
