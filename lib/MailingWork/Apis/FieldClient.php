<?php

/**
 * List Api Class.
 */

namespace bconnect\MailingWork\Apis;

use bconnect\MailingWork\BaseApiClient;

/**
 * This class implements all list management functions.
 */
class FieldClient extends BaseApiClient
{

    public function getAllowedFieldTypes()
    {
        return [
            'varchar',
            'text',
            'int',
            'float',
            'boolean',
            'enum',
            'set',
            'date',
            'time',
            'datetime',
            'email',
            'sms',
            'fax',
            'country',
            'postcode',
            'profilingpermission'
        ];
    }

    public function createField(
        $name,
        $type,
        $description = FALSE,
        $options = FALSE,
        $format = FALSE,
        $default = FALSE
    )
    {
        return $this->client->request('createField', [
            'name' => $name,
            'type' => $type,
            'advanced' => [
                'description' => ($description) ? $description : NULL,
                'options' => ($options) ? $options : '',
                'format' => ($format) ? $format : '',
                'default' => ($default) ? $default : '',
            ]
        ]);
    }

    public function updateFieldById(
        $id,
        $name = FALSE,
        $alias = FALSE,
        $substitute = FALSE,
        $descr = FALSE,
        $type = FALSE,
        $default = FALSE,
        $options = FALSE,
        $format = FALSE
    )
    {
        return $this->client->request('updateFieldById', [
            'id' => $id,
            'advanced' => [
                'name' => ($name) ? $name : '',
                'alias' => ($alias) ? $alias : '',
                'substitute' => ($substitute) ? $substitute : '',
                'descr' => ($descr) ? $descr : '',
                'type' => ($type) ? $type : '',
                'default' => ($default) ? $default : '',
                'options' => ($options) ? $options : '',
                'format' => ($format) ? $format : '',
            ]
        ]);
    }

    public function getFields()
    {
        return $this->client->request('getFields');
    }

    public static function getErrorCodes()
    {
        return [
            'createField' => [
                2 => 'Field limit hit',
                3 => 'Missing name for a field',
                4 => 'Unkown datatype',
                5 => 'Too many options'
            ]
        ];
    }

}
