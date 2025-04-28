<?php

namespace app\utilities;

use app\utilities\JWTGenerator;
use Ratchet\Http\HttpServer;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Loop;
use React\Socket\SocketServer;
use React\Socket\TcpServer;
use React\Socket\TcpServer as ReactorServer;
use React\Socket\ConnectionInterface as ReactConn;

require 'vendor/autoload.php';

class NotificationServer implements MessageComponentInterface
{
    protected $clients;
    private $secretKey = 'Abracadabra@Hogwarts1959';

    public function __construct($loop)
    {
        $this->clients = new \SplObjectStorage;

        $tcpServer = new TcpServer('127.0.0.1:56781', $loop);
        $tcpServer->on('connection', function (ReactConn $conn) {
            echo 'TCP server connected!';
            $conn->on('data', function ($msg) {
                echo "Received message: $msg\n";
                $msg = json_decode($msg, true);
                $uid = $msg['uid'];
                unset($msg['uid']);

                if (is_array($uid)) {
                    foreach ($this->clients as $client) {
                        foreach ($uid as $userId) {
                            if ($this->clients[$client] === $userId) {
                                $client->send(json_encode($msg));
                            }
                        }
                    }
                } elseif (is_numeric($uid)) {
                    foreach ($this->clients as $client) {
                        if ($this->clients[$client] === $uid) {
                            $client->send(json_encode($msg));
                        }
                    }
                }
            });
        });
    }

    function onOpen(ConnectionInterface $conn)
    {
        $queryString = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryString, $queryParams);
        if (isset($queryParams['token'])) {
            $token = $queryParams['token'];

            $uid = JWTGenerator::verifyJWT($token, $this->secretKey);

            if ($uid > 0) {
                $this->clients->attach($conn, $uid);
                echo "New connection from $uid!\n";
            } elseif ($uid === 0) {
                $this->clients->attach($conn, 'server');
                echo "New connection from server!\n";
            } else {
                echo "Invalid token!\n";
                $conn->close();
            }
        } else {
            echo "No token provided!\n";
            $conn->close();
        }
    }

    function onClose(ConnectionInterface $conn)
    {
        $uid = $this->clients[$conn];
        $this->clients->detach($conn);
        echo "Connection $uid has disconnected\n";
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }

    function onMessage(ConnectionInterface $from, $msg) {}
}

$loop = Loop::get();
$wsServer = new WsServer(new NotificationServer($loop));
$httpServer = new HttpServer($wsServer);
$server = new IoServer($httpServer, new SocketServer('0.0.0.0:56780', loop: $loop), $loop);

echo "Notification server started on port 56780\nDo not colse this window unless you want to stop the server.\n";

$server->run();
