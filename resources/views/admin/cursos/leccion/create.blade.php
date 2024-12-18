<div class="modal-header">
    <h5 class="modal-title" id="crearLeccionLabel">Nueva Leccion</h5>
    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
</div>
{{ html()->form('POST', '/admin/cursos/leccion/')->attributes(['autocomplete'=>'off','files'=>'true','class'=>'formL'])->open() }}
<div class="modal-body">
    <div class="mb-3">
        <label class="form-label" for="titulo">Titulo:</label>
        <input class="form-control" name="titulo" id="titulo" type="text" placeholder="Ingrese el titulo de la lección">
    </div>
    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripcion:</label>
        <textarea class="form-control" name="descripcion" id="descripcion" placeholder="Ingrese la descripción del curso" rows="5"></textarea>
    </div>
    <div class="mb-3">
        <label class="form-label" for="categoria">Categoria:</label>
        <input class="form-control" name="categoria" id="categoria" type="text" placeholder="Ingrese el titulo de la lección">
    </div>
    <div class="mb-3">
        <label for="video" class="form-label">Video:</label>
        <select class="form-select" name="video" id="video" aria-label="Selector de videos">
            <option selected>Seleccione una video</option>
            @foreach($videos as $id => $nombre)
            <option value="{{ $id }}">{{ $nombre }}</option>
            @endforeach
        </select>
    </div>
    <input class="form-control" name="curso" id="curso" type="hidden" value="{{ $curso }}">
    <div class="mb-3">
        <label for="archivo">Recursos:</label>
        <input type="text" name="recursos" class="form-control" id="recursos" hidden="hidden">
        <div class="wrapper-upload">
            <div class="form">
                <input type="file" name="archivo" class="file-input" id="archivo" accept="*" hidden>
                <i class="fa-solid fa-cloud-upload"></i>
                <p>Examinar archivo para cargar</p>
            </div>
            <section class="upload progress-area"></section>
            <section class="upload uploaded-area"></section>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="reset" class="btn btn-secondary" data-coreui-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-primary" onclick="cambiarNombre()">Guardar</button>
</div>
{{ html()->form()->close() }}

<script>
    const form = document.querySelector(".form"),
    fileInput = document.querySelector(".file-input"),
    progressArea = document.querySelector(".progress-area"),
    uploadedArea = document.querySelector(".uploaded-area"),
    form_upload = document.querySelector("form#crear-form"),
    nombres = document.querySelector("#recursos"),
    token = document.querySelector("[name='_token']").value;

    var Swalmodal = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success ms-3 text-white fw-semibold",
            cancelButton: "btn btn-danger text-white fw-semibold"
        },
        buttonsStyling: false
    });

    var iconos = {
        'pdf': 'fa-light fa-file-pdf',
        'doc': 'fa-light fa-file-word',
        'docx': 'fa-light fa-file-word',
        'xls': 'fa-light fa-file-excel',
        'ppt': 'fa-regular fa-file-powerpoint',
        'pptx': 'fa-regular fa-file-powerpoint',
        'xlsx': 'fa-light fa-file-excel',
        'xlsm': 'fa-light fa-file-excel',
        'zip': 'fa-light fa-file-zipper',
        'rar': 'fa-light fa-file-zipper',
        'txt': 'fa-light fa-file-lines',
        'default': 'fa-light fa-file',
        'css': 'fa-regular fa-file-code',
        'html':'fa-regular fa-file-code',
        'php': 'fa-regular fa-file-code',
        'js':'fa-regular fa-file-code',
        'cs':'fa-regular fa-file-code',
        'py':'fa-regular fa-file-code',
        'sql':'fa-regular fa-file-code',
    };

    form.addEventListener("click", () => {
        fileInput.click();
    });

    fileInput.onchange = ({ target }) => {
        let file = target.files[0];
        if (file) {
            let fileName = file.name;
            if (fileName.length >= 12) {
                let splitName = fileName.split('.');
                fileName = splitName[0].substring(0, 6) + "..."+ splitName[0].substring(splitName[0].length-7)+ "." + splitName[1];
            }
            let typeFile = file.type.split('/')[0];
            uploadFile(file, fileName, typeFile, file.name);
        }
    }

    function uploadFile(file, name, type, name2) {
        var data = new FormData();
        data.append("archivo",file);
        let fileSize = 0;
        let xhr = new XMLHttpRequest();

        xhr.upload.onprogress = (e) => {
            let fileLoaded = Math.floor((e.loaded / e.total) * 100);
            let fileTotal = Math.floor(e.total / 1000);
            (fileTotal < 1024) ? fileSize = fileTotal + " KB" : fileSize = (e.loaded / (1024 * 1024)).toFixed(2) + " MB";
            if (type == 'image') {
                let progressHTML = `<li class="row-upl">
                            <i class="fa-light fa-file-image"></i>
                            <div class="content">
                                <div class="details">
                                    <span class="name">${name} • Uploading</span>
                                    <span class="percent">${fileLoaded}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: ${fileLoaded}%"></div>
                                </div>
                            </div>
                        </li>`;
                uploadedArea.classList.add("onprogress");
                progressArea.innerHTML = progressHTML;
                if (e.loaded == e.total) {
                    progressArea.innerHTML = "";
                    let uploadedHTML = `<li class="row-upl">
                            <div class= "content">
                                <i class="fa-light fa-file-image"></i>
                                <div class="details">
                                    <span class="name">${name} • Uploaded</span>
                                    <span class="size">${fileSize}</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-check"></i>
                        </li>`;
                    uploadedArea.classList.remove("onprogress");
                    uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
                }
            } else if (type == 'video') {
                let progressHTML = `<li class="row-upl">
                            <i class="fa-light fa-file-video"></i>
                            <div class="content">
                                <div class="details">
                                    <span class=name">${name} • Uploading</span>
                                    <span class="percent">${fileLoaded}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: ${fileLoaded}%"></div>
                                </div>
                            </div>
                        </li>`;
                uploadedArea.classList.add("onprogress");
                progressArea.innerHTML = progressHTML;
                if (e.loaded == e.total) {
                    progressArea.innerHTML = "";
                    let uploadedHTML = `<li class="row-upl">
                            <div class= "content">
                                <i class="fa-light fa-file-video"></i>
                                <div class="details">
                                    <span class="name">${name} • Uploaded</span>
                                    <span class="size">${fileSize}</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-check"></i>
                        </li>`;
                    uploadedArea.classList.remove("onprogress");
                    uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
                }
            } else if (type == 'audio') {
                let progressHTML = `<li class="row-upl">
                            <i class="fa-light fa-file-music"></i>
                            <div class="content">
                                <div class="details">
                                    <span class=name">${name} • Uploading</span>
                                    <span class="percent">${fileLoaded}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: ${fileLoaded}%"></div>
                                </div>
                            </div>
                        </li>`;
                uploadedArea.classList.add("onprogress");
                progressArea.innerHTML = progressHTML;
                if (e.loaded == e.total) {
                    progressArea.innerHTML = "";
                    let uploadedHTML = `<li class="row-upl">
                            <div class= "content">
                                <i class="fa-light fa-file-music"></i>
                                <div class="details">
                                    <span class="name">${name} • Uploaded</span>
                                    <span class="size">${fileSize}</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-check"></i>
                        </li>`;
                    uploadedArea.classList.remove("onprogress");
                    uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
                }
            } else {
                var extension = name2.split('.').pop().toLowerCase();
                if (iconos.hasOwnProperty(extension)) {
                    var icono = iconos[extension];
                } else {
                    var icono = iconos['default'];
                }
                let progressHTML = `<li class="row-upl">
                            <i class="${icono}"></i>
                            <div class="content">
                                <div class="details">
                                    <span class=name">${name} • Uploading</span>
                                    <span class="percent">${fileLoaded}%</span>
                                </div>
                                <div class="progress-bar">
                                    <div class="progress" style="width: ${fileLoaded}%"></div>
                                </div>
                            </div>
                        </li>`;
                uploadedArea.classList.add("onprogress");
                progressArea.innerHTML = progressHTML;
                if (e.loaded == e.total) {
                    progressArea.innerHTML = "";
                    let uploadedHTML = `<li class="row-upl">
                            <div class= "content">
                                <i class="${icono}"></i>
                                <div class="details">
                                    <span class="name">${name} • Uploaded</span>
                                    <span class="size">${fileSize}</span>
                                </div>
                            </div>
                            <i class="fa-solid fa-check"></i>
                        </li>`;
                    uploadedArea.classList.remove("onprogress");
                    uploadedArea.insertAdjacentHTML("afterbegin", uploadedHTML);
                }
            }
        };
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                var jsonResponse = JSON.parse(xhr.responseText);
                if (nombres.value == ''){
                    nombres.value = nombres.value + jsonResponse.archivo;
                }
                else{
                    nombres.value = nombres.value + ';' + jsonResponse.archivo;
                }
                console.log(nombres.value)
                Swalmodal.fire(
                    'Cargado!',
                    'El archivo se ha cargado satisfactoriamente.',
                    'success'
                )
                fileInput.value=''
            } else {
                console.error('Error en la solicitud. Estado:', xhr.status, 'Texto:', xhr.statusText);
                Swalmodal.fire(
                    'Error',
                    'Hubo un error al cargar el archivo. Revise la consola para más detalles.',
                    'error'
                );
            }
        };
        xhr.open("POST", "/cargar/file",true);
        xhr.setRequestHeader('X-CSRF-TOKEN', token);
        xhr.send(data);
    }
</script>