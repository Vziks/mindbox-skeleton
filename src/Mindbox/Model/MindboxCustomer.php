<?php

namespace App\Mindbox\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class MindboxCustomer
 * @package App\Mindbox\Model
 *
 * @Serializer\XmlRoot("customer")
 * @Serializer\ExclusionPolicy("all")
 */
class MindboxCustomer
{
    /**
     * @var int
     *
     * @Serializer\Type("integer")
     */
    protected $id;

    /**
     * @var array
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"registration", "websitelogin"})
     *
     * @Serializer\Expose()
     */
    private $ids = [];

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("lastName")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Groups({"registration"})
     * @Serializer\Expose()
     * @Assert\Regex(
     *     pattern = "/^[а-яА-ЯёЁ]+$/ui",
     *     message = "Неверный формат"
     * )
     */
    protected $lastName;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("firstName")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Groups({"registration"})
     * @Assert\Regex(
     *     pattern = "/^[а-яА-ЯёЁ]+$/ui",
     *     message = "Неверный формат"
     * )
     * @Serializer\Expose()
     */
    protected $firstName;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("middleName")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Groups({"registration"})
     * @Assert\Regex(
     *     pattern = "/^[а-яА-ЯёЁ]+$/ui",
     *     message = "Неверный формат"
     *
     * )
     * @Serializer\Expose()
     */
    protected $middleName;

    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("mobilePhone")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Groups({"registration", "websitelogin", "callback"})
     * @Serializer\Expose()
     * @Assert\Regex(
     *     pattern = "/^7[\d]{10}$/",
     *     message = "Неверный формат"
     * )
     */
    protected $mobilePhone;


    /**
     * @var string
     * @Serializer\Type("string")
     * @Serializer\SerializedName("password")
     * @Serializer\Groups({"registration"})
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Expose()
     */
    protected $password;

    /**
     * @var string
     * @Assert\Email()
     * @Serializer\Type("string")
     * @Serializer\Groups({"registration", "websitelogin", "popup"})
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\Expose()
     */
    protected $email;

    /**
     * @var MindboxSubscription[]|ArrayCollection
     * @Serializer\Type("ArrayCollection<App\Mindbox\Model\MindboxSubscription>")
     * @Serializer\XmlList(entry="subscription")
     * @Serializer\Groups({"registration", "popup"})
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose()
     */
    protected $subscriptions;

    /**
     * @var MindboxArea
     * @Serializer\Type("App\Mindbox\Model\MindboxArea")
     * @Serializer\XmlList(entry="ids")
     * @Serializer\Groups({"registration"})
     * @Serializer\MaxDepth(3)
     * @Serializer\Expose()
     */
    protected $area;

    /**
     *
     * @Serializer\Type("array")
     * @Serializer\Groups({"registration"})
     * @Serializer\SerializedName("customFields")
     * @Serializer\Expose()
     */
    protected $customFields = [];




    /**
     * @param $customFieldName
     * @param $value
     */
    public function addCustomField($customFieldName, $value)
    {
        $this->customFields[$customFieldName] = $value;
    }

    /**
     * @param $customFieldName
     */
    public function deleteCustomField($customFieldName)
    {
        unset($this->customFields[$customFieldName]);
    }

    /**
     * @param $customFieldName
     * @return array
     */
    public function getCustomField($customFieldName)
    {
        return $this->customFields[$customFieldName];
    }

    /**
     * @param $customFieldName
     * @param $value
     * @throws \Exception
     */
    public function setCustomField($customFieldName, $value)
    {
        if (!isset($this->customFields[$customFieldName])) {
            throw new \Exception("customField [{$customFieldName}] not found");
        }
        $this->customFields[$customFieldName] = $value;
    }


    /**
     * MindboxCustomer constructor.
     */
    public function __construct()
    {
        $this->subscriptions = new ArrayCollection();;
    }


    /**
     * @return MindboxSubscription[]|ArrayCollection
     */
    public function getSubscriptions()
    {
        return $this->subscriptions;
    }

    /**
     * @param MindboxSubscription[]|ArrayCollection $subscriptions
     */
    public function setSubscriptions($subscriptions): void
    {
        $this->subscriptions = $subscriptions;
    }


    /**
     * @param MindboxSubscription $subscriptions
     * @return $this
     */
    public function addSubscriptions(MindboxSubscription $subscriptions): self
    {
        if (!$this->subscriptions->contains($subscriptions)) {
            $this->subscriptions[] = $subscriptions;
        }

        return $this;
    }

    /**
     * @param MindboxSubscription $subscriptions
     * @return $this
     */
    public function removeSubscriptions(MindboxSubscription $subscriptions): self
    {
        if ($this->subscriptions->contains($subscriptions)) {
            $this->subscriptions->removeElement($subscriptions);
        }

        return $this;
    }


    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return MindboxCustomer
     */
    public function setLastName(string $lastName): MindboxCustomer
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return MindboxCustomer
     */
    public function setFirstName(string $firstName): MindboxCustomer
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     * @return MindboxCustomer
     */
    public function setMiddleName(string $middleName): MindboxCustomer
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * @return string
     */
    public function getMobilePhone(): ?string
    {
        return $this->mobilePhone;
    }

    /**
     * @param string $mobilePhone
     */
    public function setMobilePhone(string $mobilePhone): void
    {
        $mobilePhone = preg_replace('/[\D]/u', '', $mobilePhone);
        $this->mobilePhone = $mobilePhone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return MindboxCustomer
     */
    public function setEmail($email): MindboxCustomer
    {
        $this->email = $email;

        return $this;
    }


    /**
     * @param $id
     * @param $value
     */
    public function addId($id, $value)
    {
        $this->ids[$id] = $value;
    }


    /**
     * @param $id
     */
    public function deleteId($id)
    {
        unset($this->ids[$id]);
    }


    /**
     * @param $id
     * @return mixed
     */
    public function getIds($id)
    {
        return $this->ids[$id];
    }


    /**
     * @param $id
     * @param $value
     * @throws \Exception
     */
    public function setIds($id, $value)
    {
        if (!isset($this->ids[$id])) {
            throw new \Exception("ID [{$id}] not found");
        }
        $this->ids[$id] = $value;
    }


    /**
     * @param string $fullName
     * @return MindboxCustomer
     */
    public function setFullName(string $fullName): MindboxCustomer
    {
        $this->fullName = $fullName;
        return $this;
    }

    /**
     * @return MindboxArea
     */
    public function getArea(): MindboxArea
    {
        return $this->area;
    }

    /**
     * @param MindboxArea $area
     */
    public function setArea(MindboxArea $area): void
    {
        $this->area = $area;
    }

    /**
     * @param int $id
     *
     * @return MindboxCustomer
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }


    /**
     * @return array
     */
    public function getCustomFields()
    {
        return $this->customFields;
    }


    /**
     * @param $customFields
     * @return $this
     */
    public function setCustomFields($customFields)
    {
        $this->customFields = $customFields;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }


}