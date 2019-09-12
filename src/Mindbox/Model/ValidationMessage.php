<?php


namespace App\Mindbox\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class ValidationMessage
 * @package App\Mindbox\Model
 *
 * @Serializer\XmlRoot("validationMessages")
 */
class ValidationMessage
{
    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\Groups({"registration"})
     */
    private $message;
    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\Groups({"registration"})
     */
    private $location;

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getLocation(): string
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation(string $location): void
    {
        $this->location = $location;
    }


}