<?php return array(
    'root' => array(
        'name' => 'redwebcambridge/redweb-theme',
        'pretty_version' => 'dev-main',
        'version' => 'dev-main',
        'reference' => 'dbd878471e1619235fa2664495f6c70aa6a270e8',
        'type' => 'library',
        'install_path' => __DIR__ . '/../../',
        'aliases' => array(),
        'dev' => true,
    ),
    'versions' => array(
        'composer/installers' => array(
            'pretty_version' => 'v2.2.0',
            'version' => '2.2.0.0',
            'reference' => 'c29dc4b93137acb82734f672c37e029dfbd95b35',
            'type' => 'composer-plugin',
            'install_path' => __DIR__ . '/./installers',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'redwebcambridge/redweb-theme' => array(
            'pretty_version' => 'dev-main',
            'version' => 'dev-main',
            'reference' => 'dbd878471e1619235fa2664495f6c70aa6a270e8',
            'type' => 'library',
            'install_path' => __DIR__ . '/../../',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
        'wpackagist-plugin/advanced-custom-fields' => array(
            'dev_requirement' => false,
            'replaced' => array(
                0 => '6.2.4',
            ),
        ),
        'wpengine/advanced-custom-fields-pro' => array(
            'pretty_version' => '6.2.4',
            'version' => '6.2.4.0',
            'reference' => NULL,
            'type' => 'wordpress-plugin',
            'install_path' => __DIR__ . '/../../../../mu-plugins/advanced-custom-fields-pro',
            'aliases' => array(),
            'dev_requirement' => false,
        ),
    ),
);
