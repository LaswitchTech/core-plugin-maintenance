//
//   Core Framework - Script file
//
//   @license    MIT (https://mit-license.org/)
//   @author     Louis Ouellet <louis@laswitchtech.com>
//

const MaintenanceRequest = function(indicator){
    $.ajax({
        url: '/endpoint.php/maintenance/status',
        type: 'GET',dataType: 'json',
        success: function(response) {
            if (response.status) {
                indicator.show();
                if(response.refresh){
                    window.location.reload();
                }
            } else {
                indicator.hide();
            }
        },
    });
}
const MaintenanceStatus = function(){

    // Create a visual indicator
    const indicator = $(document.createElement('i')).attr({
        "id": "maintenance-indicator",
        "class": "position-fixed start-50 translate-middle-x bi bi-exclamation-triangle-fill text-warning animate-fade",
        "style": "z-index:9999;font-size:5rem;top: 64px;"
    }).prependTo('body');

    // Hide the indicator by default
    indicator.hide();

    // Request the maintenance status every 10seconds
    setInterval(function(){
        MaintenanceRequest(indicator);
    }, 10000);

    // Initial request
    MaintenanceRequest(indicator);
}

// Initialize the maintenance status check
$( document ).ready(function() {
    MaintenanceStatus();
});
