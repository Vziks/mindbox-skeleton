<?php

namespace App\Mindbox\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class MindboxSubscription
 * @package App\Mindbox\Model
 *
 * @Serializer\XmlRoot("subscription")
 */
class MindboxSubscription
{
    /**
     * @var boolean
     *
     * @Serializer\Type("boolean")
     * @Serializer\Groups({"registration"})
     * @Serializer\SerializedName("isSubscribed")
     * @Serializer\Expose()
     */
    private $isSubscribed = true;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"registration"})
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\SerializedName("topic")
     * @Serializer\Expose()
     */
    private $topic = 'Sberbank-arm';

    /**
     * @var string
     *
     * @Serializer\Type("string")
     * @Serializer\Groups({"registration", "popup"})
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\SerializedName("pointOfContact")
     * @Serializer\Expose()
     */
    private $pointOfContact;

    /**
     * @var boolean
     *
     * @Serializer\Type("boolean")
     * @Serializer\Groups({"registration"})
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\SerializedName("valueByDefault")
     * @Serializer\Expose()
     */
    private $valueByDefault = true;

    /**
     * MindboxSubscription constructor.
     * @param string $topic
     * @param string $pointOfContact
     */
    public function __construct(string $pointOfContact = 'Email', string $topic = null)
    {
        $this->topic = $topic ? $topic : getenv('MINDBOX_ENDPOINTID');
        $this->pointOfContact = $pointOfContact;
    }

    /**
     * @return bool
     */
    public function isSubscribed(): bool
    {
        return $this->isSubscribed;
    }

    /**
     * @param bool $isSubscribed
     * @return MindboxSubscription
     */
    public function setIsSubscribed(bool $isSubscribed): MindboxSubscription
    {
        $this->isSubscribed = $isSubscribed;
        return $this;
    }

    /**
     * @return string
     */
    public function getTopic(): string
    {
        return $this->topic;
    }

    /**
     * @param string $topic
     */
    public function setTopic(string $topic): void
    {
        $this->topic = $topic;
    }

    /**
     * @return bool
     */
    public function isValueByDefault(): bool
    {
        return $this->valueByDefault;
    }

    /**
     * @param bool $valueByDefault
     */
    public function setValueByDefault(bool $valueByDefault): void
    {
        $this->valueByDefault = $valueByDefault;
    }

    /**
     * @return string
     */
    public function getPointOfContact()
    {
        return $this->pointOfContact;
    }

    /**
     * @param string $pointOfContact
     *
     * @return MindboxSubscription
     */
    public function setPointOfContact($pointOfContact)
    {
        $this->pointOfContact = $pointOfContact;
        return $this;
    }


}