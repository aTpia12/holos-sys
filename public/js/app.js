$(document).ready(function(){

    let buttonRegister = document.getElementById("buttonRegister");

    buttonRegister.addEventListener('click', function (event) {
        let name = document.getElementById("name").value;
        let email = document.getElementById("email").value;
        let phone = document.getElementById("phone").value;

        let fields = [name, email, phone];

        if(fields.includes(''))
        {
            Swal.fire({
                title: "Todos los campos son requeridos",
                text: "Por favor completa el formulario",
                icon: "warning"
            });
            return;
        }

        $('#modal-reserve').removeClass('hidden');

        var formData = new FormData();
        formData.append('name', name);
        formData.append('email', email);
        formData.append('phone', phone);

        $.ajax({
            url: 'api/initial-reserve',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                Swal.fire({
                    title: response.message,
                    text: response.txt,
                    icon: response.type,
                    showCancelButton: false,
                    confirmButtonColor: "#0A267F",
                    cancelButtonColor: "#808184",
                    confirmButtonText: "Ok"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "/"
                    }
                });
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: "Hubo un problema!",
                    text: "intenta de nuevo!",
                    icon: "error"
                });
            }
        });
    });
});
