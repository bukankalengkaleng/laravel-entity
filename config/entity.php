<?php

return [
    /**
     * NAMESPACE
     * A configuration for the entity's Form Requests' and Controllers' namespace,
     * when using argument: '--namespace=Both'
     *
     */
    'namespace' => [
        'backend'  => 'Admin',
        'frontend' => 'Frontend',
    ],

    /**
     * MODEL
     * A configuration for the entity's model
     *
     */
    'model' => [

        /**
         * The entity's model namespace.
         *
         */
        'namespace' => 'Models',    // output: namespace App\Models;

        /**
         * Set a base model for your entity
         * If set to 'true' then your entity model will use Laravel default base model
         *
         * The 'custom_base_directory' key is always prefixed by 'app/',
         * so if you give it a 'MyDir' value, then your custom base model will created under:
         * 'app/MyDir/MyBaseModel.php'
         *
         */
        'should_use_default_base' => true,
        'custom_base_directory'   => '',
        'custom_base_name'        => 'MyBaseModel',
    ],

    /**
     * DUMMY SEEDER
     * Dummy seeder actually a seeder generated from Model's factory
     * It purpose is to make a dummy (obviously) data
     */
    'dummy' => [
        'should_create' => true,          // Whether the dummy seeds has to be created
        'directory'     => 'dummies',     // /database/seeds/dummies
    ],
];
