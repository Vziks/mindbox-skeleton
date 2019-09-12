<?php


namespace App\Mindbox;


use App\Mindbox\Exception\MindBoxClientException;
use App\Mindbox\Operations\AbstractOperation;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use JMS\Serializer\SerializationContext;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class MindBoxHandler
{

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * MindBoxHandler constructor.
     * @param LoggerInterface $mindBoxLogger
     * @param RequestStack $requestStack
     */
    public function __construct(LoggerInterface $mindBoxLogger, RequestStack $requestStack)
    {
        $this->logger = $mindBoxLogger;
        $this->requestStack = $requestStack;
    }

    /**
     * @param AbstractOperation $operation
     * @return mixed|void|null
     */
    public function run(AbstractOperation $operation)
    {
        $handleResponse = null;
        $operation->setDeviceUUID($this->requestStack);

        $client = new Client([
            'timeout' => 10,
        ]);

        $request = new Request(
            $operation->getMethod(),
            $this->decorateUri($operation),
            $this->decorateHeaders($operation)
        );

        $options = $this->decorateRequest($operation);

        try {

            $this->logger->debug("REQUEST: " . json_encode($options['body']) ,
                [
                    'METHOD' => $operation->getMethod(),
                    'URI' => (string) $request->getUri(),
                    'HEADERS' => $request->getHeaders(),
                ]
            );
            if ($operation->isAsync()) {
                $client->sendAsync($request, $options);
                return;
            }

            $response = $client->send($request, $options);

            $this->logger->debug($response->getBody()->getContents());
        } catch (ClientException $e) {
            $exceptionResponse = $e->getResponse();
            $statusCode = $exceptionResponse instanceof ResponseInterface ? (int)$exceptionResponse->getStatusCode() : null;
            $data = null;
            try {
                if (method_exists($exceptionResponse, 'getBody')) {
                    dump($exceptionResponse->getBody()->getContents());
                    $data = $exceptionResponse->getBody()->getContents();
                }
            } catch (\Exception $e) {
                $data = null;
            }

            $this->logger->error(json_encode([$e->getCode(), $data]));
        } catch (ConnectException $e) {
            $this->logger->error(json_encode($e->getMessage()));
            throw new MindBoxClientException($e);
        } catch (\Exception $e) {
            $this->logger->error(json_encode($e->getMessage()));
            throw new MindBoxClientException($e);
        } catch (GuzzleException $e) {
            $this->logger->error(json_encode($e->getMessage()));
        }

        if ($data && 200 === $statusCode) {
            $response->getBody()->rewind();
            $handleResponse = $this->handleResponse($response, $operation);
        }

        return $handleResponse;
    }

    private function decorateRequest(AbstractOperation $operation)
    {
        $options = [];

        $options = array_merge_recursive($options, $operation->getOptions($this->getSerializer()));

        return $options;
    }

    private function decorateHeaders(AbstractOperation $operation)
    {
        $headers = [
            'Authorization' => 'Mindbox secretKey="' . $operation->getMindboxSecretKey() . '"',
            'X-Customer-IP' => $this->requestStack->getMasterRequest()->getClientIp(),
        ];

        $headers = array_merge_recursive($headers, $operation->getHeaders());

        return $headers;
    }

    private function decorateUri(AbstractOperation $operation)
    {
        return $operation->getUri() . (\count($operation->getQuery()) > 0 ? '?' . http_build_query($operation->getQuery()) : '');
    }

    /**
     * @param ResponseInterface $response
     * @param AbstractOperation $operation
     *
     * @return mixed
     */
    private function handleResponse(ResponseInterface $response, AbstractOperation $operation)
    {
        $serializer = $this->getSerializer();

        return $operation->getResponse($response, $serializer);
    }

    /**
     * @return \JMS\Serializer\SerializerInterface
     */
    final public static function getSerializer()
    {
        return \JMS\Serializer\SerializerBuilder::create()
            ->setSerializationContextFactory(function () {
                return SerializationContext::create()
                    ->setSerializeNull(true);
            })
            ->build();
    }

}