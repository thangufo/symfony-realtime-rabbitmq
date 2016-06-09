<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }

    /**
     * @Route("/test", name="testpage")
     */
    public function testAction(Request $request)
    {
        // replace this example code with whatever you need
        return new JsonResponse([
            'test' => 'hello'
        ]);
    }

    /**
     * @Route("/send-to-rabbit", name="send-to-rabbit")
     */
    public function sendToRabbitAction(Request $request)
    {
        $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();

        $channel->queue_declare('hello', false, false, false, false);
        $msg = new AMQPMessage('Message to websocket');
        $channel->basic_publish($msg,"amq.topic","mymessage");

//        $msg = new AMQPMessage('Hello World!');
//        $channel->basic_publish($msg, '', 'hello');

        $channel->close();
        $connection->close();

        // replace this example code with whatever you need
        return new JsonResponse([
            'test' => 'hello'
        ]);
    }
}
