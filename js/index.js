$(function () {
    // initialize dropzone and validation of it
    const myDropzone = new Dropzone("#my-dropzone", {
        url: "#",
        maxFiles: 1, // Aceptar solo un archivo
        addRemoveLinks: true,
        acceptedFiles: 'image/*', // Aceptar solo imágenes
        dictDefaultMessage: 'Click para subir el archivo o arrastralo acá', // Mensaje personalizado
        init: function() {
            this.on("maxfilesexceeded", function(file) {
                this.removeAllFiles(); // Eliminar archivos anteriores si se intenta subir más de uno
                this.addFile(file); // Añadir el nuevo archivo
            });
        }
    });

    // Phone library validator to initialize
    const phoneInputField = document.querySelector("#phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"
    });

    // Assign function events to the buttons
    $("#previous-form-button").on("click", sendPreviewFormButton);
    $("#send-form-button").on("click", sendSubmitFormButton);

    function sendPreviewFormButton(event) {
        // Get all of the validations of the inputs
        const formData = new FormData($("#staff-form")[0]);
        
        const name_validation = validateNameInput(formData.get("name"));
        const email_validation = validateEmailInput(formData.get("email"));
        const phone_validation = validatePhoneInput(formData.get("phone"), phoneInput);
        const image_validation = validateImageFileInput(myDropzone);
        const description_validation = validateDescriptionInput(formData.get("description"));

        if(name_validation && email_validation && phone_validation && image_validation && description_validation){
            
            // Append files from Dropzone to formData
            myDropzone.files.forEach(function(file) {
                formData.append('image_file', file);
            });

            $.ajax({
                type: "POST",
                url: "./backend/index.php",
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function (response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            });
        }else{
            alert("Validación incompleta");
            event.preventDefault();
            return false;
        }
        
    }

    function sendSubmitFormButton(event) {
        // Get all of the validations of the inputs
        const formData = new FormData($("#staff-form")[0]);
        
        const name_validation = validateNameInput(formData.get("name"));
        const email_validation = validateEmailInput(formData.get("email"));
        const phone_validation = validatePhoneInput(formData.get("phone"), phoneInput);
        const image_validation = validateImageFileInput(myDropzone);
        const description_validation = validateDescriptionInput(formData.get("description"));

        if(name_validation && email_validation && phone_validation && image_validation && description_validation){
            
            // Append files from Dropzone to formData
            myDropzone.files.forEach(function(file) {
                formData.append('image_file', file);
            });

            $.ajax({
                type: "POST",
                url: "./backend/View.php",
                data: formData,
                processData: false,  // tell jQuery not to process the data
                contentType: false,  // tell jQuery not to set contentType
                success: function (response) {
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    var err = eval("(" + xhr.responseText + ")");
                    alert(err.Message);
                }
            });
        }else{
            alert("Validación incompleta!!!");
            event.preventDefault();
            return false;
        }
    }
});
