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

		this.sendMessage = function() {

		}
	});