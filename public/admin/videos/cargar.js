const form = document.querySelector(".form"),
    fileInput = document.querySelector(".file-input"),
    progressArea = document.querySelector(".progress-area"),
    uploadedArea = document.querySelector(".uploaded-area"),
    form_upload = document.querySelector("form#crear-form"),
    nombres = document.querySelector("#files"),
    token = document.querySelector("[name='csrfmiddlewaretoken']").value;
var data = new FormData();

form.addEventListener("click", () => {
    fileInput.click();
});

fileInput.onchange = ({ target }) => {
    let file = target.files[0];
    if (file) {
        let fileName = file.name;
        if (fileName.length >= 12) {
            let splitName = fileName.split('.');
            fileName = splitName[0].substring(0, 12) + "... ." + splitName[1];
        }
        let typeFile = file.type.split('/')[0];
        if (nombres.value == ''){
            nombres.value = nombres.value + file.name;
        }
        else{
            nombres.value = nombres.value + ',' + file.name;
        }
        console.log(nombres.value)
        uploadFile(file, fileName, typeFile, file.name);
    }
}

function uploadFile(file, name, type, name2) {
    data.append("csrfmiddlewaretoken",token);
    data.append('nombre',name2)
    data.append("archivo",file);
    let xhr = new XMLHttpRequest();
    xhr.upload.onprogress = (e) => {
        let fileLoaded = Math.floor((e.loaded / e.total) * 100);
        let fileTotal = Math.floor(e.total / 1000);
        let fileSize;
        (fileTotal < 1024) ? fileSize = fileTotal + " KB" : fileSize = (e.loaded / (1024 * 1024)).toFixed(2) + " MB";
        if (type == 'image') {
            let progressHTML = `<li class="row-upl">
                        <i class="fa-light fa-file-image"></i>
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
    xhr.open("POST", "../crear_archivo/",true);
    xhr.send(data);
}