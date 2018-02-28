# requester
A request maker made in JS and PHP

# options
You can use different options passing them as an array to the Requester class. Those are the different values that can be passed as options when making the request:

- **no_return:** Deactivates the return of the body (CURLOPT_RETURNTRANSFER=0)
- **setopt:** Pass different curlopt constants to activate them. *For example, you could pass setopt=>[CURLOPT_RETURNTRANSFER => 1, CURLOPT_AUTOREFERER => true]*
- **timeout:** Timeout in seconds
- **connect_timeout:** Connection timeout in seconds
- **keep_alive:** Activates CURLOPT_TCP_KEEPALIVE, with an interval of 15
- **headers:** An array of extra headers to send *(For example, headers => ['Authorization' => 'Bearer 1234', 'Extra-Key' => 'Extra-value']*
- **httpquery:** Instead of passing the params on the $params array on the function call, you could pass a string with the http query format directly (For example, a=b&c=d&e[]=f). This will override the standard way of sending parameters.
- **bg:** Sends an asynchronous curl, performing the unix command *curl -s "http://www.url.com" > /dev/null 2>&1 &*. It also accepts the parameters *timeout*, *connect_timeout*, *keep_alive*, *headers*
- **jsondecode_output:** Performs a json_decode over the body of the return of the request.
- **json:** Returns the result and curl info in json format instead of a php array.
