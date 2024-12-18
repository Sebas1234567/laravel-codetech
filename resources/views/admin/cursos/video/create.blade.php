<div class="modal-header">
    <h5 class="modal-title" id="crearVideoLabel">Nuevo Video</h5>
    <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
</div>
{{ html()->form('POST', '/admin/cursos/video/')->attributes(['autocomplete'=>'off','files'=>'true'])->open() }}
<div class="modal-body">
    <div class="mb-3">
        <label class="form-label" for="nombre">Nombre:</label>
        <input class="form-control" name="nombre" id="nombre" type="text" placeholder="Ingrese el nombre del video">
    </div>
    <div class="mb-3">
        <label for="multi-select-calidades">Calidad:</label>
        <select class="form-multi-select" name="calidades[]" id="calidades" multiple data-coreui-search="true" data-coreui-selection-type="tags"></select>
    </div>
    <div class="mb-3">
        <label class="form-label" for="extension">Extension:</label>
        <select class="form-select" name="extension" id="extension" aria-label="select extension">
            <option selected="">Seleccione una extensión</option>
            <option value="mp4">mp4</option>
            <option value="mkv">mkv</option>
            <option value="mov">mov</option>
            <option value="avi">avi</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label" for="url">Videos: </label>
        <input class="form-control" name="url" id="url" type="text" placeholder="Ingrese las urls de los videos separadas por ;">
    </div>
    <div class="mb-3">
        <label for="archivo">Archivo:</label>
        <span>Nombre archivos: <b>subtitulos-codigoidioma-IDIOMA.vtt</b>; <b>poster-titulopost.ext</b></span>
        <input type="text" name="files" class="form-control" id="files" hidden="hidden">
        <div class="wrapper-upload">
            <div class="form">
                <input type="file" name="archivo" class="file-input" id="archivo" accept="image/* ,.vtt" hidden>
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
    const options = [{
        value: 144,
        text: '144p'
    }, {
        value: 240,
        text: '240p'
    }, {
        value: 360,
        text: '360p'
    }, {
        value: 480,
        text: '480p'
    },{
        value: 720,
        text: '720p'
    },{
        value: 1080,
        text: '1080p'
    }];
    const select3 = document.getElementById('calidades');
    const select3c = new coreui.MultiSelect(select3, {
        multiple: true,
        selectionType: 'tags',
        search: true,
        options
    });
    select3c._element.name=select3c._element.name+'[]';
</script>

<script>
    const form = document.querySelector(".form"),
    fileInput = document.querySelector(".file-input"),
    progressArea = document.querySelector(".progress-area"),
    uploadedArea = document.querySelector(".uploaded-area"),
    form_upload = document.querySelector("form#crear-form"),
    nombres = document.querySelector("#files"),
    token = document.querySelector("[name='_token']").value;

    var Swalmodal = Swal.mixin({
        customClass: {
            confirmButton: "btn btn-success ms-3 text-white fw-semibold",
            cancelButton: "btn btn-danger text-white fw-semibold"
        },
        buttonsStyling: false
    });

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
            } else {
                let progressHTML = `<li class="row-upl">
                            <i class="fa-light fa-file"></i>
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
                                <i class="fa-light fa-file"></i>
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