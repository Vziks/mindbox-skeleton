<?php


namespace App\Mindbox\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class Result
 * @package App\Mindbox\Model
 *
 * @Serializer\XmlRoot("result")
 */
class MindboxResponse
{
    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("status")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Groups({"registration"})
     * @Serializer\Expose()
     */
    private $status;
    /**
     * @var ValidationMessage[]
     * @Serializer\Type("array<App\Mindbox\Model\ValidationMessage>")
     * @Serializer\SerializedName("validationMessages")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Groups({"registration"})
     * @Serializer\Expose()
     */
    private $validationMessages;

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }


    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    /**
     * @return ValidationMessage[]
     */
    public function getValidationMessages(): array
    {
        return $this->validationMessages;
    }

    /**
     * @param ValidationMessage[] $validationMessages
     */
    public function setValidationMessages(array $validationMessages): void
    {
        $this->validationMessages = $validationMessages;
    }




}