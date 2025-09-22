API.error(function(xhr, status, error, endpoint){
    if(!MAINTENANCE_MODE && status === 503){
        window.location.href = window.location.href;
    }
});
