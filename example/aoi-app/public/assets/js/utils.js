const $GET = 'GET';
const $POST = 'POST';
const $PUT = 'PUT';
const $PATCH = 'PATCH';
const $DELETE = 'DELETE';
const WARNING = 2;
const ERROR = 1;
const SUCCESS = 0;

/**
 * @param form <object>
 * @param url <string>
 * @param method <string>
 * @param others <object> <optional>
 * others.isJson <boolean> <when send object you must be set to "true">
 * others.isHTML <boolean> <when you want get response html>
 * others.isHideNotif <boolean> <when you want get response json without display notif>
 * others.isAlert <boolean>
 * others.alertTitle <string>
 * Example use:
 * if submit form data
 * sendFormData($('[name="form-add"]')[0], 'example/tes', 'post')
 * if send obj 
 * sendFormData({name:'tes'}, 'example/tes', 'post', {isJson:true}})
 * if want return html
 * sendFormData({name:'tes'}, 'example/tes', 'post', {isJson:true, isHTML: true}})
 * 
*/

/**
 * @param form <object>
 * @param url <string>
 * @param method <string>
 * @param others <object> <optional>
 * others.isJson <boolean> <when send object you must be set to "true">
 * others.isHTML <boolean> <when you want get response html>
 * others.isHideNotif <boolean> <when you want get response json without display notif>
 * others.isAlert <boolean>
 * others.alertTitle <string>
 * Example use:
 * if submit form data
 * sendFormData($('[name="form-add"]')[0], 'example/tes', 'post')
 * if send obj 
 * sendFormData({name:'tes'}, 'example/tes', 'post', {isJson:true}})
 * if want return html
 * sendFormData({name:'tes'}, 'example/tes', 'post', {isJson:true, isHTML: true}})
 * 
*/
async function sendFormData(form = "", url = "", method = "POST", others = {}) {
    let formData;
    let data = {};
    let $msg = "";
    if (url == "") {
        notify({ statusType: WARNING, text: 'Url is not set' })
        return;
    }
    if (method.toLowerCase == $POST.toLowerCase) {
        $msg = 'Success save data';
    }
    if (method.toLowerCase == $PUT.toLowerCase) {
        $msg = 'Updated data success';
    }
    if (method.toLowerCase == $DELETE.toLowerCase) {
        $msg = 'Delete data success';
    }

    if (others.isAlert) {
        if (!confirm(`Are you sure to ${others.alertTitle ? others.alertTitle : ""} this ?`)) {
            return false;
        }
    }

    if (others.isJson) {
        form.submit = 1;
        data.data = form;
        data.method = method;
    } else {
        formData = new FormData(form);
        formData.append('submit', 1);
        data.data = formData;
        data.method = method;
        data.isFormData = true;
    }
    data.isHTML = others.isHTML ? others.isHTML : false;
    try {
        let response = await request(url, data);
        if (response) {
            if (others.isHTML) {
                return response;
            }
            if (others.isHideNotif) {
                return response;
            } else {
                notify({ statusType: response.error, text: response.message ? response.message : $msg });
            }
            if (response.redirect) {
                SETTIMEOUT(() => { REDIRECT(response.redirect) });
                return;
            }
            //Reload when status error = 0
            if (response.error === SUCCESS) {
                if (response.isRefresh === false) {
                    return response;
                } else if (response.isRefresh === true) {
                    SETTIMEOUT('refresh');
                } else {
                    SETTIMEOUT('refresh');
                }

            }

            return response;
        } else {
            notify({ statusType: ERROR, text: 'System cannot proceed your request, please try again later' })
            return;
        }
    } catch (error) {
        console.log('Error 🚩 ', error.message);
        return { statusType: ERROR, text: 'System cannot proceed your request, please try again later' };

    }

}

function SETTIMEOUT(handler, time = 2000) {
    if (handler == 'refresh') {
        setTimeout(() => {
            window.location.reload();
        }, time);
    } else {
        setTimeout(handler, time);
    }
}

function REDIRECT(url) {
    window.location.href = url;
}

/**
 * @param url <string>
 * @param others<object> 
 * others.method <string>
 * others.headers <string> <optional> <custome headers>
 * others.data <object>
 * others.isFormData <boolean> <optional> <if want use form data>
 * others.isHTML <boolean> <optional> <if want return html>
*/
async function request(url, others = {}) {
    others.method = others.method ? others.method : $GET.toLowerCase();
    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

    //Set default headers
    let headers = {
        method: others.method, // *GET, POST, PUT, DELETE, etc.
        credentials: "same-origin",
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    }

    //Custome headers
    if (others.headers) {
        headers = others.headers;
    }

    //Set method to lowercase
    others.method = others.method.toLowerCase();

    if (typeof url == "undefined") {
        notify({ statusType: WARNING, text: 'Url is not set' });
        return;
    }
    if (others.data == "" && others.method == $POST.toLowerCase()) {
        notify({ statusType: WARNING, text: 'Data is not set' });
        return;
    }
    if (others.data == "" && others.method == $PUT.toLowerCase()) {
        notify({ statusType: WARNING, text: 'Data is not set' });
        return;
    }
    if (others.data == "" && others.method == $PATCH.toLowerCase()) {
        notify({ statusType: WARNING, text: 'Data is not set' });
        return;
    }

    if (others.isFormData && others.method) {
        headers.headers = {};
        others.data = others.data;
    } else {
        others.data = new URLSearchParams(others.data)
    }

    //Init type request
    headers.headers['X-Requested-With'] = 'XMLHttpRequest';
    headers.headers['X-CSRF-TOKEN'] = csrf;

    if (others.method == $POST.toLowerCase()
        || others.method == $PUT.toLowerCase()) {
        headers.body = others.data // body data type must match "Content-Type" header
    } else {
        url += "?" + new URLSearchParams(others.data);
    }

    const response = await fetch(url, headers);
    if (others.isHTML) {
        return response.text();
    } else {
        return response.json(); // parses JSON response into native JavaScript objects
    }
}
/**
 * download simple notify in https://github.com/simple-notify/simple-notify and inmport in template
 * @param param <objects>
 * param.title
 * param.text
 * param.status
 * param.type
 * param.autoClose
 * param.position
 * param.setTimeOut
 * param.effect
 * param.customClass
 * param.customIcon
*/
function notify(param = {}) {
    switch (param.statusType) {
        case 2:
        case 'warning':
            param.status = 'warning';
            param.title = 'Warning!';
            break;
        case 1:
        case 'error':
            param.status = 'error';
            param.title = 'Oops!';
            break;
        case 0:
        case 'success':
            param.status = 'success';
            param.title = 'Success';
            break;
        default:
            param.status = 'error';
            param.title = 'Notification';
            break;
    }
    param.title = param.title ? param.title : 'Message';
    param.text = param.text ? param.text : 'Notify text lorem ipsum';
    param.status = param.status ? param.status : 'error'; //warning, success, error
    param.type = param.type ? param.type : 3; // type: 1/2/3
    param.autoClose = param.autoClose ? param.autoClose : true;
    param.position = param.position ? param.position : 'right top';
    param.setTimeOut = param.setTimeOut ? param.setTimeOut : 1500;
    param.effect = param.effect ? param.effect : 'slide'; // effect: fade/slide
    param.customClass = param.customClass ? param.customClass : '';
    param.customIcon = param.customIcon ? param.customIcon : '';
    new Notify({
        status: param.status,
        title: param.title,
        text: param.text,
        effect: param.effect,
        speed: 300,
        customClass: param.customClass,
        customIcon: param.customIcon,
        showIcon: true,
        showCloseButton: true,
        autoclose: param.autoClose,
        autotimeout: param.setTimeOut,
        gap: 20,
        distance: 20,
        type: param.type,
        position: param.position
    })
}