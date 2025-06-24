<?php

/**
 * Core Framework - MaintenanceCommand
 *
 * @license    MIT (https://mit-license.org/)
 * @author     Louis Ouellet <louis@laswitchtech.com>
 */

// Import additionnal class into the global namespace
use LaswitchTech\Core\Abstracts\Command;

class MaintenanceCommand extends Command {

    /**
     * Constructor
     */
    public function __construct()
    {
        // Call Parent Constructor
        parent::__construct();
    }

    /**
     * Enable maintenance mode
     */
    public function onAction()
    {
        // Set maintenance mode
        $this->Config->set('application', 'maintenance', true);

        // Output the status
        $this->statusAction();
    }

    /**
     * Disable maintenance mode
     */
    public function offAction()
    {
        // Set maintenance mode
        $this->Config->set('application', 'maintenance', false);

        // Output the status
        $this->statusAction();
    }

    /**
     * Check maintenance mode
     */
    public function statusAction()
    {
        // Output the stored value
        if($this->Config->get('application', 'maintenance') == true){
            $this->Output->print("Maintenance mode is on");
        } else {
            $this->Output->print("Maintenance mode is off");
        }
    }
}
