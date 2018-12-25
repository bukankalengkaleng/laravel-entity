<?php

return [
    /**
     * NAMESPACE
     * A configuration for the entity's Form Requests' and Controllers' namespace,
     * when using argument '--namespace=Both'
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
         * The directory where your models will resides, also act as their namespace.
         * eg: namespace App\Models;
         *
         */
        'directory' => 'app/Models',

        /**
         * Set a base model for your entity
         * Set to 'Illuminate\Database\Eloquent\Model' to have a default Laravel base model
         *
         */
        'base' => 'Illuminate\Database\Eloquent\Model',
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
