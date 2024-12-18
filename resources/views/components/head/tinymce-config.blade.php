<script src="{{ asset('admin/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
<script>
    const token = document.head.querySelector('meta[name="csrf-token"]').content;
    const image_upload_handler_callback = (blobInfo, progress) => new Promise((resolve, reject) => {
        const xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '/filetiny');
        xhr.setRequestHeader('X-CSRF-TOKEN', token);

        xhr.upload.onprogress = (e) => {
            progress(e.loaded / e.total * 100);
        };

        xhr.onload = () => {
            if (xhr.status === 403) {
                reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
                return;
            }
            if (xhr.status < 200 || xhr.status >= 300) {
                reject('HTTP Error: ' + xhr.status);
                return;
            }
            const json = JSON.parse(xhr.responseText);
            if (!json || typeof json.location != 'string') {
                reject('JSON Inválido: ' + xhr.responseText);
                return;
            }
            resolve(json.location);
        };

        xhr.onerror = () => {
            reject('Carga de imagen fallida. Code: ' + xhr.status);
        };

        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());    
        xhr.send(formData);
    });

    tinymce.init({
        selector: '.editorTiny',
        language: "es",
        height: "500",
        plugins: 'image code print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons advtable export',
        toolbar: 'undo redo | bold italic underline | fontfamily fontsize forecolor| alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | link image media code preview',
        images_upload_url: '/filetiny',
        images_upload_handler: image_upload_handler_callback,
        relative_urls: false,
        remove_script_host: false,
        tinycomments_mode: 'embedded',
        tinycomments_author: 'CodeTech',
    });
</script>