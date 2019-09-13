#### Configuration
Add to config/packages/monolog.yaml
```
monolog:
    channels:
        ['mindbox']
    handlers:
        mindbox:
            type: rotating_file
            path: "%kernel.logs_dir%/%kernel.environment%-mindbox.log"
            level: debug
            channels: ["mindbox"]
```            

Add to config/services.yaml
```
services:
    _defaults:
        bind:
            $mindBoxLogger: '@monolog.logger.mindbox'
```            
   
Add to .ENV
```
#DirectCRM
MINDBOX_HOST=https://api.mindbox.ru
MINDBOX_URI=/v3/operations
MINDBOX_SECRET_KEY=D061p764m85bklq
MINDBOX_COKKIE_NAME=mindboxDeviceUUID
MINDBOX_ENDPOINTID=MindboxRu
```        
### Usage
```
Inject to method 
public function index(Request $request, MindBoxHandler $mindboxHandler, SerializerInterface $serializer)

$mindboxRequest = new MindboxRequest($model);

$operation = new CallbackOperation($mindboxRequest);

$result = $mindboxHandler->run($operation);

### Example
http://127.0.0.1:8000/mindbox

```

### How to use

To add new method for work 
Create class and extends from 
App\Mindbox\Operations\AbstractOperation

And implement abstract method
Example:
````
class PopupOperation extends AbstractOperation
{

    public function getName()
    {
        return 'popup';
    }
}
````

Default config method:
````
'Method' => 'POST'
'Content-Type' => 'application/json'
'Accept' => 'application/json'
'SERIALIZATION_CONTEXT_JSON' => 'json'
````
If need, you can override any method by your context

Then add fields for serialization and set the group to these fields as well as the parameter in the getName () method
@Serializer\Groups({"popup"})

````
/**
* @var MindboxCustomer
* @Serializer\Type("App\Mindbox\Model\MindboxCustomer")
* @Serializer\SerializedName("customer")
* @Serializer\XmlElement(cdata=false)
* @Serializer\Groups({"popup"})**
* @Serializer\Expose()
*/
private $customer;
````

Full example see in folder src/Mindbox/Model

``````

$operation = new PopupOperation();
// To run Request Async create object with true param in constructor
$operation = new PopupOperation(true);
$operation->setModel($model);

$result = $mindboxHandler->run($operation);
``````





  