$(document).ready(function() {
    $(".upload_button").on('change', '#photo', function() {
        $("#preview").html('');
        $("#preview").html('<img src="loader.gif" alt="Uploading...."/>');

        // Use AjaxForm to handle form submission
        $("#image_upload_form").ajaxForm({
            //target: '#preview', // This targets the #preview div
            success: showResponse // This calls the showResponse function upon success
        }).submit(); // Submit the form via AJAX
    });
});

// Function to handle the response after the form is successfully uploaded
function showResponse(response) {
    try {
        var data = JSON.parse(response); // Parse the JSON response

        if (data.success) {
            // If the upload is successful, display the uploaded image
            $('#preview').html('<img src="uploads/' + data.file_path + '" alt="Uploaded Image" />');
        } else {
            // If the response indicates an error, show the error message
            alert(data.error || "An error occurred.");
        }
    } catch (error) {
        console.error("Error parsing JSON:", error); // Log any JSON parsing errors
        alert("An error occurred while processing the response.");
    }
}
