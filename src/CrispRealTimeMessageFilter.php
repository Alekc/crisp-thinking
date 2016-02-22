<?php
namespace Alekc\CrispThinking;

class CrispRealTimeMessageFilter {

    /**
     * Constructs a new CrispRealTimeMessageFilter object that will connect to the specified appliance
     * @param string server The name of the server to connect to
     * @param int port The port on the server to connect to
     */
    function __construct($server, $port) {
        date_default_timezone_set('UTC');
        $this->server = $server;
        $this->port = $port;
        $this->timeout = array ("sec"=>5, "usec"=>0);
        $this->attempts = 2;
    }

    /**
     * Set the timeout for receiving data in milliseconds
     * @param int $timeout time in milliseconds
     */
    public
    function setTimeout($timeout) {
        $sec = $timeout / 1000;
        $usec = $timeout % 1000;
        $this->timeout = array("sec"=>$sec, "usec"=>$usec);
    }

    /**
     * Set the number of attempts to get a response
     * @param int $attempts number of attempts
     */
    public
    function setAttempts($attempts) {
        $this->attempts = $attempts;
    }

    /**
     * Sends an evaluate request to the server and returns response object
     * @param string id The id token
     * @param string sender The senders id
     * @param string receiver The receivers id
     * @param stirng message The message to evaluate
     * @param string opaque Opaque data. Will be strored but not processed by the server
     * @param string type Type of chat message - currently 'private' for a private conversation (1-1), or 'chatroom' for a chatroom are supported
     * @param bool white_mode bool True for white list mode, False for Black
     * @param array groups array of server groups to use
     * @return Object Object containing the response details from the server or error details if an error occurs
     */
    public
    function evaluate($id, $sender, $receiver, $message, $opaque, $type, $white_mode, $groups)
    {
        $request = $this->createEvaluateRequest($id, $sender, $receiver, $message, $opaque, $type, $white_mode, $groups);
        return $this->call($request);
    }

    /**
     * Send an event request to the server and returns servers response
     * @param string id string The id token
     * @param string sender The senders id
     * @param string receiver The receivers id
     * @param string event The event i.e. login
     * @param array eventdata array  Hashed array of additional eventdata
     * @param int level int Level
     * @return Object Object containing the response details from the server or error details if an error occurs
     */
    public
    function event($id, $sender, $receiver, $event, $eventdata, $level)
    {
        $request = $this->createEventRequest($id, $sender, $receiver, $event, $eventdata, $level);
        return $this->call($request);
    }

    /**
     *
     * Creates an evaluate request ready to send to the server
     * @param string id The id token
     * @param string sender The senders id
     * @param string receiver The receivers id
     * @param stirng message The message to evaluate
     * @param string opaque Opaque data. Will be strored but not processed by the server
     * @param string type Type of chat message - currently 'private' for a private conversation (1-1), or 'chatroom' for a chatroom are supported
     * @param bool white_mode bool True for white list mode, False for Black
     * @param array groups array of server groups to use
     * @return Object - Object containing the request object to be json encoded and sent to the server
     */
    protected
    function createEvaluateRequest($id, $sender, $receiver, $message, $opaque, $type, $white_mode, $groups)
    {
        $sent_at = new DateTime();

        if(count($groups) == 0) {
            $groups = array ( 'all' );
        }
        $params = array ( 'sender' => $sender,
                          'receiver' => $receiver,
                          'message' => $message,
                          'opaque' => $opaque,
                          'type' => $type,
                          'message' => $message,
                          'sent_at' => $sent_at->format(DATE_ATOM),
                          'white_mode' => $white_mode,
                          'groups' => $groups );
        $request = array ( 'id' => $id,
                           'method' => 'evaluate',
                           'params' => $params );

        return $request;
    }

    /*
            * Creates an event request ready to send to the server
          * @param string id string The id token
            * @param string sender The senders id
            * @param string receiver The receivers id
            * @param string event The event i.e. login
          * @param array eventdata array - Hashed array of additional eventdata
            * @param int level int Level
            * @return Object Object containing the request object to be json encoded and sent to the server
      */
    protected
    function createEventRequest($id, $sender, $receiver, $event, $eventdata, $level)
    {
        $sent_at = new DateTime();

        $params = array ( 'sender' => $sender,
                          'receiver' => $receiver,
                          'event' => $event,
                          'event_data' => $eventdata,
                          'level' => $level,
                          'sent_at' => $sent_at->format(DATE_ATOM) );
        $request = array ( 'id' => $id,
                           'method' => 'event',
                           'params' => $params );

        return $request;
    }

    /**
     * Creates an error response
     * @param string id The id token
     * @param int code The error code
     * @param string description The error string
     * @return Object The response object
     */
    protected
    function createErrorResponse($id, $code, $desc)
    {
        $error->code = $code;
        $error->description = $desc;
        $response->id = $id;
        $response->error = $error;
        return $response;
    }

    /**
     * Sends a request to the server and returns the response
     * @param Object request The request object, will be JSON encoded and sent to the server
     * @return Object The JSON decoded response object returned by the server or an error object if an error occurs
     */
    protected
    function call($request)
    {
        $json = json_encode($request);
        $json = "$json\n";
        //echo "json=$json";
        $tries = 0;
        while($tries++ < $this->attempts) {
            $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            $response = null;
            //echo "preconnect try $tries\n";
            if(socket_connect($socket, $this->server, $this->port)) {
                //echo "connect\n";
                socket_set_block($socket);
                socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, $this->timeout);
                socket_write($socket, $json);
                //echo "written\n";
                $jsonresponse = $buffer = '';
                do {
                    socket_recv($socket, $buffer, 4096, 0);
                    //echo "Read $buffer\n";
                    $jsonresponse .= $buffer;
                } while(strlen($buffer) != 0 && strpos($buffer, "\n") == false);
                $response = json_decode($jsonresponse);
                return $response;
            } else {
                $response = $this->createErrorResponse($request['id'], -1, "Unable to connect to server");
            }
        }

        return $response;
    }

    /**
     * Send an evaluate request to the server and returns servers response. Any html tags < /> will be stripped before sending to the server and reinserted afterwards. (so effectively ignored for processing
     * @param string id The id token
     * @param string sender The senders id
     * @param string receiver The receivers id
     * @param stirng message The message to evaluate
     * @param string opaque Opaque data. Will be strored but not processed by the server
     * @param string type Type of chat message - currently 'private' for a private conversation (1-1), or 'chatroom' for a chatroom are supported
     * @param bool white_mode bool True for white list mode, False for Black
     * @param array groups array of server groups to use
     * @return Object Object containing the response details from the server or error details if an error occurs
     */
    public
    function htmlevaluate($id, $sender, $receiver, $message, $opaque, $type, $white_mode, $groups)
    {
        # HTML Regex to use
        $HTMLREGEX='/<\/?\w+(?:(?:\s+\w+(?:\s*[:=]\s*(?:".*?"|\'.*?\'|[^\'">\s]+))?)+\s*|\s*)\/?>/';
        return $this->regexevaluate($id, $sender, $receiver, $message, $opaque, $type, $white_mode, $groups, $HTMLREGEX);
    }

    /** @function regexevaluate
     * Send an evaluate request to the server and returns servers response. Any matches to the regex will be stripped before sending to the server and reinserted afterwards. (so effectively ignored for processing)
     * @param string id The id token
     * @param string sender The senders id
     * @param string receiver The receivers id
     * @param stirng message The message to evaluate
     * @param string opaque Opaque data. Will be strored but not processed by the server
     * @param string type Type of chat message - currently 'private' for a private conversation (1-1), or 'chatroom' for a chatroom are supported
     * @param bool white_mode bool True for white list mode, False for Black
     * @param array groups array of server groups to use
     * @param regex regex Regex to use to strip text
     * @return Object Object containing the response details from the server or error details if an error occurs
     */
    public
    function regexevaluate($id, $sender, $receiver, $message, $opaque, $type, $white_mode, $groups, $regex)
    {
        # Get list of matches with offsets
        preg_match_all($regex, $message, $matches, PREG_OFFSET_CAPTURE);
        # Strip Regex Matches
        $rmfmessage=preg_replace($regex, '', $message);
        # Create request with stripped message and send to server
        $request = $this->createEvaluateRequest($id, $sender, $receiver, $rmfmessage, $opaque, $type, $white_mode, $groups);
        $response = $this->call($request);
        # If no error, check if we need to reinsert the regex matches
        if($response->error == NULL) {
            if($response->result->max_result != NULL && $response->result->max_result == 0) {
                // Max result 0 - therefore nothing changed - simply put original message back in string
                $response->filtered_string = $message;
            } else {
                // Server has filtered string - reinsert matches
                $response->filtered_string = $this->insert_matches($response->filtered_string, $matches);
            }
        }
        return $response;
    }

    /**
     * Internal use to reinsert regex matches back into returned string
     * @param string message The message to insert text back into
     * @parma string matches The list of matches to insert
     */
    protected
    function insert_matches($message, $matches) {
        foreach($matches[0] as $i => $match) {
            // Insert match into string at offset
            $message = substr_replace($message, $match[0], $match[1], 0);
        }
        return $message;
    }
}
