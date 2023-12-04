<?php

/**
 * List Api Class.
 */

namespace bconnect\MailingWork\Apis;

use bconnect\MailingWork\BaseApiClient;

/**
 * This class implements all list management functions.
 */
class ListClient extends BaseApiClient
{

    /**
     * Get all lists.
     *
     * @return List[]
     */
    public function getLists()
    {
        return $this->client->request('getlists');
    }

    /**
     * Create a new list.
     *
     * @param string $name List name.
     * @param string $description Set a description for a list.
     * @param integer $folderId Set folder for the new created list.
     *
     * @return int new list id.
     */
    public function createList($name, $description = FALSE, $folderId = FALSE)
    {
        return $this->client->request('createList', [
            'name' => $name,
            'advanced' => [
                'folderid' => ($description) ? $description : '',
                'description' => ($folderId) ? $description : NULL
            ]
        ]);
    }

    /**
     * Update a existing list.
     *
     * @param int $listId id of the list to update.
     * @param string $name new list name.
     * @param string $description Set a description for a list.
     * @param int $folderId Set folder for the new created list.
     *
     * @return int status.
     */
    public function updateListById($listId, $name, $description = FALSE, $folderId = FALSE)
    {
        return $this->client->request('updateListById', [
            'listId' => $listId,
            'name' => $name,
            'advanced' => [
                'folderid' => ($description) ? $description : '',
                'description' => ($folderId) ? $description : NULL
            ]
        ]);
    }

    /**
     * Empty a list by a id.
     *
     * @param int $listId List id to remove all entries.
     *
     * @return int status
     */
    public function emptyList($listId)
    {
        return $this->client->request('emptyList', [
            'listId' => $listId
        ]);
    }

    /**
     * Remove a list by a id.
     *
     * @param int $listId List id to remove.
     *
     * @return int status
     */
    public function deleteListById($listId)
    {
        return $this->client->request('deleteListById', [
            'listId' => $listId
        ]);
    }

    /**
     * Get count from a list.
     *
     * @param int $listId List id to count.
     *
     * @return int count
     */
    public function getRecipientCountByListId($listId)
    {
        return $this->client->request('getRecipientCountByListId', [
            'listId' => $listId
        ]);
    }

    /**
     * Get recipients.
     *
     * @param int $listId Get recipient id for a list.
     *
     * @return int[] recipient ids.
     */
    public function getRecipientIdsByListId($listId)
    {
        return $this->client->request('getRecipientIdsByListId', [
            'listId' => $listId
        ]);
    }

    /**
     * Get opt status by list id.
     *
     * @param int $listId Get recipient id for a list.
     *
     * @return array status.
     */
    public function getOptStatusByListId($listId)
    {
        return $this->client->request(
            'getOptStatusByListId', [
                'listId' => $listId
            ]
        );
    }


    public static function getErrorCodes()
    {
        return [

        ];
    }

}
