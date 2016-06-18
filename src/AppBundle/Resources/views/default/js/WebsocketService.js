angular.module('realtimeApp').service('WebsocketService',
	function () {
		// Connection parameters
		var mq_username = "rabbit_user",
			mq_password = "rabbit_password",
			mq_vhost    = "/",
			mq_url      = 'http://' + window.location.hostname + ':15674/stomp';

		//setup the RabbitMQ connection
		var ws = new SockJS(mq_url);
		var client = Stomp.over(ws);

		// RabbitMQ SockJS does not support heartbeats so disable them
		client.heartbeat.outgoing = 0;
		client.heartbeat.incoming = 0;
		var queues = [];
		var connected = false;

		var onConnect = function() {
			connected = true;
			for (var i=0;i<queues.length;i++) {
				client.subscribe(queues[i].queue, queues[i].callback);
			}
			queues = {};
		}
		var onError = function() {
			console.log("Can not connect !!!");
		}
		// Make sure the user has limited access rights
		client.connect(mq_username, mq_password, onConnect, onError, mq_vhost);

		this.subscribe = function(queue, callback) {
			if (connected) {
				//if connected to websocket the subscribe to the STOMP message queue
				client.subscribe(queue, callback);
			} else  {
				//otherwise, push the request to a queue, to be subscribed later
				queues.push({
					'queue': queue,
					'callback': callback
				});
			}
		}
	});