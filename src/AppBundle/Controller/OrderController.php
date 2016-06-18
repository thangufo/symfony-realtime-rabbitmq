<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Order;
use AppBundle\Entity\Repository\OrderRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class OrderController extends Controller
{
    /**
     * Get all the request
     *
     * @Route("/order", name="list_order")
     * @Method({"GET"})
     */
    public function listAction(Request $request)
    {
        /** @var OrderRepository $repo */
        $repo = $this->getDoctrine()->getEntityManager()->getRepository("AppBundle:Order");
        $orders = $repo->findAll();

        return new JsonResponse($orders);
    }

    /**
     * Submit the request
     *
     * @Route("/order", name="post_order")
     * @Method({"POST"})
     */
    public function submitAction(Request $request)
    {
        $content = json_decode($request->getContent(),true);
        $order = new Order();
        $order->setRequest($content['request']);
        $order->setRequestTime(new \DateTime());
        $order->setStatus(0);
        $em = $this->getDoctrine()->getManager();
        $em->persist($order);
        $em->flush();

        $content['id'] = $order->getId();
        $content['status'] = 0;
        $this->sendToRabbit("newOrder",$content);

        return new JsonResponse([
            'id' => $order->getId()
        ]);

        $this->sendToRabbit("neworder",$content);
    }

    /**
     * Accept the order
     *
     * @Route("/order/{id}/approve", name="approve_order")
     * @Method({"POST"})
     */
    public function approveAction(Request $request,$id)
    {
        /** @var OrderRepository $repo */
        $repo = $this->getDoctrine()->getEntityManager()->getRepository("AppBundle:Order");
        /** @var Order $order */
        $order = $repo->find($id);
        $order->setStatus(Order::STATUS_ACCEPTED);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $this->sendToRabbit("orderAction",[
            'id' => $id,
            'status' => Order::STATUS_ACCEPTED
        ]);
        return new JsonResponse();
    }

    /**
     * Reject the order
     *
     * @Route("/order/{id}/reject", name="reject_order")
     * @Method({"POST"})
     */
    public function rejectAction(Request $request,$id)
    {
        /** @var OrderRepository $repo */
        $repo = $this->getDoctrine()->getEntityManager()->getRepository("AppBundle:Order");
        /** @var Order $order */
        $order = $repo->find($id);
        $order->setStatus(Order::STATUS_REJECTED);
        $em = $this->getDoctrine()->getManager();
        $em->flush();

        $this->sendToRabbit("orderAction",[
            'id' => $id,
            'status' => Order::STATUS_REJECTED
        ]);

        return new JsonResponse();
    }

    /**
     * @param string $message
     */
    private function sendToRabbit($queue, $message)
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'rabbit_user', 'rabbit_password');
        $channel = $connection->channel();

        //$channel->queue_declare('hello', false, false, false, false);
        $msg = new AMQPMessage(json_encode($message));
        $channel->basic_publish($msg,"amq.topic",$queue);

        $channel->close();
        $connection->close();
    }
}