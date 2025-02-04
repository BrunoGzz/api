if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(
        loadWeather, 
        null, 
        {
           enableHighAccuracy: true,
           timeout: 5000,
           maximumAge: 0
        });
} else { 
    alert("Geolocation is not supported by this browser.");
}

function loadWeather(position) {
    alert(position.coords.latitude);
    alert(position.coords.longitude);
}