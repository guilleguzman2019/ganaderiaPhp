<?php
require_once 'vendor/autoload.php';
 
define('ONEDRIVE_CLIENT_ID', 'e0e816bd-4a85-4533-a2c6-364b89538b0d');
define('ONEDRIVE_CLIENT_SECRET', 'PHk8Q~Eq~Ocq1T1.o1jU-tdo1LRXLxSsbqx6Na~p');
define('ONEDRIVE_SCOPE', 'files.read files.read.all files.readwrite files.readwrite.all offline_access');
define('ONEDRIVE_CALLBACK_URL', 'http://localhost/onedrive/callback.php'); // in my case it is http://localhost/sajid/onedrive/callback.php
 
$config = [
    'callback' => ONEDRIVE_CALLBACK_URL,
    'keys'     => [
                    'id' => ONEDRIVE_CLIENT_ID,
                    'secret' => ONEDRIVE_CLIENT_SECRET
                ],
    'scope'    => ONEDRIVE_SCOPE,
    'authorize_url_parameters' => [
            'approval_prompt' => 'force',
            'access_type' => 'offline'
    ]
];
 
$adapter = new Hybridauth\Provider\MicrosoftGraph( $config );