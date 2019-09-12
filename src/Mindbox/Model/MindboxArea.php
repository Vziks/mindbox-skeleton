<?php

namespace App\Mindbox\Model;

use JMS\Serializer\Annotation as Serializer;

/**
 * Class MindboxArea
 * @package App\Mindbox\Model
 */
class MindboxArea
{
    /**
     * @var array
     * @Serializer\Type("array")
     * @Serializer\XmlElement(cdata=false)
     * @Serializer\SerializedName("ids")
     * @Serializer\Groups({"registration"})
     * @Serializer\Expose()
     */
    private $ids = [];

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

}