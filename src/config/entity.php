<?php

return [
    /**
     * NAMESPACE
     * A configuration for the entity's:
     * - Form Requests
     * - Controllers
     *
     */

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
];
