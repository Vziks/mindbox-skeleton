<?php


namespace App\Mindbox\Model;


use JMS\Serializer\Annotation as Serializer;

/**
 * Class MindboxRequest
 * @package App\Mindbox\Model
 *
 * @Serializer\XmlRoot("operation")
 */
class MindboxRequest
{
    /**
     * @var MindboxCustomer
     * @Serializer\Type("App\Mindbox\Model\MindboxCustomer")
     * @Serializer\SerializedName("customer")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Groups({"registration", "websitelogin", "callback", "popup"})
     * @Serializer\Expose()
     */
    private $customer;

    /**
     * OperationRequest constructor.
     * @param MindboxCustomer $customer
     */
    public function __construct(MindboxCustomer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return MindboxCustomer
     */
    public function getCustomer(): MindboxCustomer
    {
        return $this->customer;
    }

    /**
     * @param MindboxCustomer $customer
     */
    public function setCustomer(MindboxCustomer $customer): void
    {
        $this->customer = $customer;
    }

}