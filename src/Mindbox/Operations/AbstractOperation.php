<?php


namespace App\Mindbox\Operations;


use App\Mindbox\Model\MindboxRequest;
use App\Mindbox\Model\MindboxResponse;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class AbstractOperation
 * @package App\Mindbox\Operations
 */
abstract class AbstractOperation
{

    const SERIALIZATION_CONTEXT_JSON = 'json';
    const SERIALIZATION_CONTEXT_XML = 'xml';

    const HEADERS = [
        self::SERIALIZATION_CONTEXT_JSON =>
            [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
        self::SERIALIZATION_CONTEXT_XML => [
            'Content-Type' => 'application/xml',
            'Accept' => 'application/xml',
        ],
    ];

    const ASYNC_POINT = '/async';
    const SYNC_POINT = '/sync';

    /**
     * @var bool
     */
    private $isAsync;

    /**
     * @var string
     */
    private $deviceUUID;

    /*
     * @var MindboxRequest
     */
    private $model;

    /**
     * TraitOperation constructor.
     * @param MindboxRequest $model
     * @param bool $isAsync
     */
    public function __construct(MindboxRequest $model, bool $isAsync = false)
    {
        $this->model = $model;
        $this->isAsync = $isAsync;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param mixed $model
     */
    public function setModel($model): void
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getEndPoint()
    {
        return getenv('MINDBOX_HOST') . getenv('MINDBOX_URI');
    }

    /**
     *
     * Set endpoint to uri
     * @return string
     */
    public function getUri()
    {
        return $this->getEndPoint() . $this->getResource();
    }

    /**
     * @return string
     */
    public function getMindboxSecretKey()
    {
        return getenv('MINDBOX_SECRET_KEY');
    }

    /**
     * @return string
     */
    public function getDeviceUUID()
    {
        return $this->deviceUUID;
    }

    /**
     *
     * Set DeviceUUID from cookie
     *
     * @param RequestStack $requestStack
     */
    public function setDeviceUUID(RequestStack $requestStack): void
    {
        $this->deviceUUID = $requestStack->getMasterRequest()->cookies->get(getenv('MINDBOX_COKKIE_NAME'));
    }

    /**
     *
     * Get IP client
     * @return string
     */
    public function getClientIp(): string
    {
        $request = Request::createFromGlobals();

        return $request->getClientIp();
    }

    /**
     * @return bool
     */
    public function isAsync(): bool
    {
        return $this->isAsync;
    }

    /**
     * Set default method request
     *
     * @return mixed
     */
    public function getMethod()
    {
        return Request::METHOD_POST;
    }

    /**
     *
     * Set format serialization
     *
     * @return string
     */
    public function getSerializationContext()
    {
        return self::SERIALIZATION_CONTEXT_JSON;
    }

    /**
     *
     * Set endpoint sync/async to uri
     *
     * @return string
     */
    public function getResource()
    {
        return !$this->isAsync() ? self::SYNC_POINT : self::ASYNC_POINT;
    }


    /**
     * Serialize object to request
     *
     * @param Serializer $serializer
     * @return array
     */
    public function getOptions(Serializer $serializer)
    {
        return ['body' => $serializer->serialize(
            $this->getModel(),
            $this->getSerializationContext(),
            SerializationContext::create()->setGroups($this->getName())
        )];
    }

    /**
     *
     * Set default headers params
     *
     * @return mixed
     */
    public function getHeaders()
    {
        return self::HEADERS[$this->getSerializationContext()];
    }

    /**
     *
     * Deserialize object from response
     *
     * @param ResponseInterface $response
     * @param Serializer $serializer
     * @return mixed
     */
    public function getResponse(ResponseInterface $response, Serializer $serializer)
    {
        return $serializer->deserialize(
            json_encode(json_decode($response->getBody()->getContents(), true)),
            MindboxResponse::class,
            $this->getSerializationContext(),
            DeserializationContext::create()->setGroups($this->getName()));
    }

    /**
     *
     * Set default query params
     *
     * @return array
     */
    public function getQuery()
    {
        return [
            'endpointId' => getenv('MINDBOX_ENDPOINTID'),
            'operation' => $this->getName(),
            'deviceUUID' => $this->getDeviceUUID()
        ];
    }

    /**
     * @return string
     */
    abstract public function getName();

}