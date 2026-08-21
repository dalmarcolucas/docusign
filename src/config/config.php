<?php

return [

    /**
     * Authentication type: 'jwt' or 'legacy'
     * JWT is recommended as legacy auth (username/password) is being phased out.
     */
    'auth_type' => 'jwt',

    /**
     * JWT Authentication Settings
     */

    /**
     * The DocuSign Integration Key (Client ID) from your app
     */
    'client_id' => '',

    /**
     * The DocuSign User ID (GUID) to impersonate
     */
    'user_id' => '',

    /**
     * The RSA private key (PEM format) for JWT signing.
     * Can be the key contents or a file path.
     */
    'private_key' => '',

    /**
     * The DocuSign OAuth server (account-d.docusign.com for demo, account.docusign.com for production)
     */
    'auth_server' => 'account-d.docusign.com',

    /**
     * JWT scopes
     */
    'jwt_scopes' => ['signature', 'impersonation'],

    /**
     * Legacy Authentication Settings (deprecated)
     */

    /**
     * The DocuSign Integrator's Key
     */
    'integrator_key' => '',

    /**
     * The Docusign Account Email
     */
    'email' => '',

    /**
     * The Docusign Account Password
     */
    'password' => '',

    /**
     * The version of DocuSign API (Ex: v2, v2.1)
     */
    'version' => 'v2.1',

    /**
     * The DocuSign Environment (Ex: demo, na1, na2, na3, eu)
     */
    'environment' => 'demo',

    /**
     * The DocuSign Account Id
     */
    'account_id' => '',


    /**
     * Envelope Trait Configs 
     */

    /**
     * Envelope ID field 
     */
    'envelope_field' => 'envelopeId',

    /**
    * Recipient IDs to save tabs for upon creating the Envelope (false = Disabled)
    */
    'save_recipient_tabs' => [1],

    /**
    * Envelope Tabs field
    */
    'tabs_field' => 'envelopeTabs',

    /**
    * Envelope Documents field (false = Disabled)
    */
    'documents_field' => 'templateDocuments',
];

