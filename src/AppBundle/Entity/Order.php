<?php
namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="request")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Repository\OrderRepository")
 */
class Order
{
    const STATUS_PENDING = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_REJECTED = -1;

    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="bigint")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $todo
     *
     * @ORM\Column(name="request", type="string", length=255, nullable=false)
     */
    private $request;

    /**
     * @var boolean $status
     *
     * @ORM\Column(name="status", type="smallint", nullable=false)
     */
    private $status;

    /**
     * @var datetime $status
     *
     * @ORM\Column(name="request_time", type="datetime", nullable=false)
     */
    private $requestTime;

    /**
     * @var datetime $status
     *
     * @ORM\Column(name="action_time", type="datetime", nullable=true)
     */
    private $actionTime;

    function __construct() {
        $this->status = self::STATUS_PENDING;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set request
     *
     * @param string $request
     *
     * @return Request
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get request
     *
     * @return string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set status
     *
     * @param integer $status
     *
     * @return Request
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set requestTime
     *
     * @param \DateTime $requestTime
     *
     * @return Request
     */
    public function setRequestTime($requestTime)
    {
        $this->requestTime = $requestTime;

        return $this;
    }

    /**
     * Get requestTime
     *
     * @return \DateTime
     */
    public function getRequestTime()
    {
        return $this->requestTime;
    }

    /**
     * Set actionTime
     *
     * @param \DateTime $actionTime
     *
     * @return Request
     */
    public function setActionTime($actionTime)
    {
        $this->actionTime = $actionTime;

        return $this;
    }

    /**
     * Get actionTime
     *
     * @return \DateTime
     */
    public function getActionTime()
    {
        return $this->actionTime;
    }
}
