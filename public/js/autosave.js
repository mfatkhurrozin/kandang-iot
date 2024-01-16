// // public/js/autosave.js
// $(document).ready(function() {
//     // Function to save sensor data when triggered
//     function saveSensorData(temperature, humidity, lux, airquality) {
//         $.ajax({
//             url: '/save-sensor-data',
//             type: 'POST',
//             data: {
//                 temperature: temperature,
//                 humidity: humidity,
//                 lux: lux,
//                 airquality: airquality,
//                 _token: $('meta[name="csrf-token"]').attr('content'), // Include CSRF token
//             },
//             success: function(response) {
//                 console.log(response.message); // Log the server response
//             },
//             error: function(xhr) {
//                 console.error('Error:', xhr.responseText); // Log any errors
//             }
//         });
//     }

//     // Example: Trigger auto-save when data changes (replace with your own logic)
//     setInterval(function() {
//         var temperature = /* Get temperature data */;
//         var humidity = /* Get humidity data */;
//         var lux = /* Get lux data */;
//         var airquality = /* Get airquality data */;

//         saveSensorData(temperature, humidity, lux, airquality);
//     }, 60000); // Auto-save every 60 seconds (adjust as needed)
// });
