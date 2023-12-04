* EmptyList (/)
* CreateList (/)
* DeleteListById (/)
* GetLists (/)
* GetRecipientCountByListId (/)
* GetRecipientIdsByListId (/)
* GetOptStatusByListId (/)
* UpdateListById (/)

### Create a new list

```
$client = Client::getClient('username', 'password');
$newListId = $client->api('list')->createList('Name of the new list', 'Description of the new list', 22);
```
