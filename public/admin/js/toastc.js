const notifications = document.querySelector(".notifications");
const toastDetails = {
    timer: 5000,
    success: {
        icon: 'fa-circle-check',
        title: 'Success',
        content: 'This is a success toast.',
    },
    danger: {
        icon: 'fa-circle-xmark',
        title: 'Error',
        content: 'This is an error toast.',
    },
    warning: {
        icon: 'fa-triangle-exclamation',
        title: 'Warning',
        content: 'This is a warning toast.',
    },
    info: {
        icon: 'fa-circle-info',
        title: 'Info',
        content: 'This is an information toast.',
    },
    help: {
        icon: 'fa-circle-question',
        title: 'Help',
        content: 'This is an help toast.',
    }
};

const removeToast = (toast,id) => {
    toast.classList.add("hide");
    if(toast.timeoutId) clearTimeout(toast.timeoutId);
    setTimeout(() => toast.remove(), 500);
    var csrfToken = $('meta[name="csrf-token"]').attr('content');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': csrfToken
        }
    });

    $.ajax({
        type: 'POST',
        url: '/admin/noti/seent/',
        data: {
            id: id,
        },
        success: function (data) {
            console.log('Success:', data);
        }
    });
};

const createToast = (id,idt,title=null,content=null,timeEnabled=false,time=null) => {
    const toastD = toastDetails[id];
    const icon = toastD.icon;
    const titled = title ? title : toastD.title;
    const contentd = content ? content : toastD.content
    const toast = document.createElement("li");
    if (timeEnabled) {
        toast.className = `toast timer ${id}`;
    } else {
        toast.className = `toast ${id}`;
    }
    toast.innerHTML = `<div class="tcolumn">
                        <i class="fa-duotone ${icon}"></i>
                        <div class="t-text">
                            <h5>${titled}</h5>
                            <span>${contentd}</span>
                        </div>
                    </div>
                    <i class="fa-solid fa-xmark" onclick="removeToast(this.parentElement)"></i>`;
    notifications.appendChild(toast);
    if(timeEnabled){
        timed = time ? time : toastDetails.timer;
        toast.timeoutId = setTimeout(() => removeToast(toast,idt), timed);
        document.styleSheets[5].addRule('.toast.timer::before', `animation-duration: ${timed/1000}s`);
    }
};