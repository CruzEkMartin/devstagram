import './bootstrap';

import Dropzone from 'dropzone';

Dropzone.autoDiscover = false;

const dropzone = new Dropzone('#dropzone', {
    dictDefaultMessage: 'Sube aquí tu imagen',
    acceptedFiles: ".png,.jpg,.jpeg,.gif",
    addRemoveLinks: true,
    dictRemoveFile: 'Borrar archivo',
    maxfiles: 1,
    uploadMultiple: false,

    //se cejecuta cuando se crea el componente dropzone
    init: function () {
        //en caso de que exista una imagen anterior la selecciona para llenar los atributos de dropzone
        if (document.querySelector('[name="imagen"]').value.trim()) {
            const imagenPublicada = {};
            imagenPublicada.size = 1234; //se puede leer el tamaño de la imagen, pero no es obligatorio
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;

            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada,`/uploads/${imagenPublicada.name}`);

            imagenPublicada.previewElement.classList.add(
                "dz-success",
                "dz-complete"
            )

        }
    },
});



dropzone.on('success', function (file, response) {
    document.querySelector('[name="imagen"]').value = response.imagen
});


dropzone.on('removedfile', function () {
    document.querySelector('[name="imagen"]').value = "";
});