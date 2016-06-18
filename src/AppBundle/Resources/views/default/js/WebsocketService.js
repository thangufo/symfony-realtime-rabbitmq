angular.module('realtimeApp').factory('WebsocketService',
	function () {
		// Connection parameters
		var mq_username = "guest",
			mq_password = "guest",
			mq_vhost    = "/",
			mq_url      = 'http://' + window.location.hostname + ':15674/stomp',

		// The queue we will read. The /topic/ queues are temporary
		// queues that will be created when the client connects, and
		// removed when the client disconnects. They will receive
		// all messages published in the "amq.topic" exchange, with the
		// given routing key, in this case "mymessages"
		mq_queue    = "/topic/mymessages";

		//setup the RabbitMQ connection
		var ws = new SockJS(mq_url);
		var client = Stomp.over(ws);

		// RabbitMQ SockJS does not support heartbeats so disable them
		client.heartbeat.outgoing = 0;
		client.heartbeat.incoming = 0;

		client.debug = onDebug;
		var onConnect = function() {
			console.log("Connected !!!");
		}
		// Make sure the user has limited access rights
		client.connect(mq_username, mq_password, onConnect, onError, mq_vhost);

		this.subscribe = function(queue, callback) {
			client.subscribe(queue, callback);
		}
	});