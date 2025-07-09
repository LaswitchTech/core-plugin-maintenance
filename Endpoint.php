<?php

// Import additionnal class into the global namespace
use \LaswitchTech\Core\Objects;
use \LaswitchTech\Core\Abstracts\Endpoint;

class MaintenanceEndpoint extends Endpoint {

    /**
     * Constructor
     */
    public function __construct()
    {

        // Call Parent Constructor
        parent::__construct();

        // Retrieve the namespace
        $namespace = $this->Request->getNamespace();

        // Set Global access
        $this->Public = true;

        // Set Properties
        switch($namespace){
            case "/maintenance/status":
                $this->Level = 1;
                break;
            case "/maintenance/on":
            case "/maintenance/off":
                $this->Public = false;
                $this->Level = 1;
                break;
        }
    }

    /**
     * Enable maintenance mode
     */
    public function onAction()
    {
        // Set the default message
        $message = ["status" => 200, "message" => "OK", "data" => []];

        // Check if the status is still OK
        if($message['status'] == 200){

            // Check the request method
            if($this->Request->getMethod() == "GET"){

                // Set maintenance mode
                $this->Config->set('application', 'maintenance', true);

                // Set the message data
                $message["data"]["status"] = $this->Config->get('application', 'maintenance');

                // Set the message
                if($message["data"]["status"]){
                    $message["data"]["message"] = "Maintenance mode is now on";
                } else {

                    // Set an error message
                    $message = ["status" => 500, "message" => "Internal Server Error", "data" => "Unable to set maintenance mode"];
                }
            } else {

                // Set an error message
                $message = ["status" => 405, "message" => "Method Not Allowed", "data" => "Invalid Request"];
            }
        }

        // Return the message
        return $message;
    }

    /**
     * Disable maintenance mode
     */
    public function offAction()
    {
        // Set the default message
        $message = ["status" => 200, "message" => "OK", "data" => []];

        // Check if the status is still OK
        if($message['status'] == 200){

            // Check the request method
            if($this->Request->getMethod() == "GET"){

                // Set maintenance mode
                $this->Config->set('application', 'maintenance', false);

                // Set the message data
                $message["data"]["status"] = $this->Config->get('application', 'maintenance');

                // Set the message
                if(!$message["data"]["status"]){
                    $message["data"]["message"] = "Maintenance mode is now off";
                } else {

                    // Set an error message
                    $message = ["status" => 500, "message" => "Internal Server Error", "data" => "Unable to set maintenance mode"];
                }
            } else {

                // Set an error message
                $message = ["status" => 405, "message" => "Method Not Allowed", "data" => "Invalid Request"];
            }
        }

        // Return the message
        return $message;
    }

    /**
     * Check maintenance mode
     */
    public function statusAction()
    {
        // Set the default message
        $message = ["status" => 200, "message" => "OK", "data" => []];

        // Check if the status is still OK
        if($message['status'] == 200){

            // Check the request method
            if($this->Request->getMethod() == "GET"){

                // Set the message data
                $message["data"]["status"] = $this->Config->get('application', 'maintenance');
                $message["data"]["refresh"] = !$this->Auth->isAuthorized('Administrator', 1);

                // Set the message
                if($message["data"]["status"]){
                    $message["data"]["message"] = "Maintenance mode is now on";
                } else {
                    $message["data"]["message"] = "Maintenance mode is now off";
                }
            } else {

                // Set an error message
                $message = ["status" => 405, "message" => "Method Not Allowed", "data" => "Invalid Request"];
            }
        }

        // Return the message
        return $message;
    }
}
