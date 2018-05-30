<?php


class call_api{

    //attributes
    private $api_key;
    private $apilink;
    
    function __construct(){
        require_once('../config/na_config.php'); //require configuration file
        $this->api_key = $api_key;
        $this->apilink = $apilink;
      }


    private function call_api($call, $data){
        //set headers
$headers = array(
    'na_apikey: '.$this->api_key.''
);

// Get cURL resource
        $curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, array(
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => "$this->apilink/$call",
    CURLOPT_USERAGENT => 'Sample Nawo web client',
    CURLOPT_POST => 1,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POSTFIELDS => array(
        "data" => $data
    )
));
// Send the request & save response to $resp
$resp = curl_exec($curl);
// Close request to clear up some resources
curl_close($curl);
$obj = json_decode($resp);
return $obj;
    } //end call_api


    //Get unique states in wards database
    function get_states(){
        $data = array();
        $data = json_encode($data);
        $call = "get_states";
        $states = $this->call_api($call, $data);

        //$states = $states->message;
        if ($states->status==200){
            return $states->message;
        } else {
            $error = "Error loading states";
            return $error;
        }
    } //end getstates
    
    //Get unique lgas given states in wards database
    function get_lgas($state){
        $data = array("state"=>$state);
        $data = json_encode($data);
        $call = "get_lgas";
        $lgas = $this->call_api($call, $data);

        //$states = $states->message;
        if ($lgas->status==200){
            return $lgas->message;
        } else {
            $error = "Error loading LGAs";
            return $error;
        }
    } //end get_lgas

    //Get unique wards given state and lga in wards database
    function get_wards($state, $lga){
        $data = array("state"=>$state, "lga"=>$lga);
        $data = json_encode($data);
        $call = "get_wards";
        $wards = $this->call_api($call, $data);

        //$states = $states->message;
        if ($wards->status==200){
            return $wards->message;
        } else {
            $error = "Error loading Wards";
            return $error;
        }
    } //end get_lgas

    function join_party($data){
        $call = "join_party";
        $result = $this->call_api($call, $data);

        if ($result->status==200){
            return $result->details;
        } else {
            $error = "Unable to process request for some reason. Please try again later";
            return $error;
        }
    } //end join party function

    function find_user_info($data){
        $call = "find_user_info";
        $result = $this->call_api($call, $data);
        if ($result->status==200){
            return $result->details;
        } else {
            $error = "Unable to process request for some reason. Please try again later";
            return $error;
        }
    }

    function find_from_hash($data){
        $call = "find_from_hash";
        $result = $this->call_api($call, $data);
        if ($result->status==200){
            return $result->details;
        } else {
            $error = "Unable to process request for some reason. Please try again later";
            return $error;
        }
    }

    function get_latest_blocks(){
        $call = "get_latest_blocks";
        $data = "";
        $result = $this->call_api($call, $data);
        if ($result->status==200){
            return $result->details;
        } else {
            $error = "Unable to process request for some reason. Please try again later";
            return $error;
        }
    }


}

?>