/**
 * Required Bootstrap 5
*/
async function MyModal(modalId = "example", others = {}) {
    let vcenter = others.isvcenter ? 'modal-dialog-centered':'';
    let vcenterscroll = others.isvcenterscroll ? 'modal-dialog-scrollable':'';
    let htmlModal = `
        <div class="modal ${modalId} fade" tabindex="-1" id="${modalId}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog ${others.className ? others.className:''} ${vcenter} ${vcenterscroll}">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title modal-title-${modalId}">${others.modalTitle ? others.modalTitle:'Modal Title'}</h5>
                    <button type="button" class="btn-close" id="close-${modalId}" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ${others.content}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="close-${modalId}" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>
   `;
    /** Remove element modal-area*/
    const classModalArea = document.querySelector(`.modal-area-${modalId}`);
    if(classModalArea){
        classModalArea.remove();
    } 
    /** End remove element modal-area*/
    /** Create element div */
    const tagDiv = document.createElement("div");
    tagDiv.innerHTML = htmlModal;
    tagDiv.classList.add(`modal-area-${modalId}`);

    document.body.appendChild(tagDiv);
    /** End create element div */
    /** Show Modal*/
    let myModal = document.getElementById(`${modalId}`);
    const Modal = new bootstrap.Modal(myModal, {backdrop: 'static'})
    Modal.show();
    /** End show Modal*/
    const classBackdropModalAll = document.querySelectorAll('.modal-backdrop');
    if(classBackdropModalAll.length > 0){
        classBackdropModalAll.forEach((element, index) => {
            if(index != 0 && index == classBackdropModalAll.length - 1){
                element.style.zIndex = 10001+index+2;
            }else{
                element.style.zIndex = 10001+index+1;
            }
        });
    }
    const classModalAll = document.querySelectorAll(`.modal`);
    classModalAll.forEach((element, index) => {
        let i = index+1;
        if(index == 0){
            element.style.zIndex = 10001 + parseInt(i+1);
        }else{
            element.style.zIndex = 10001 + parseInt(i+2);
        }
    });
    /** Remove element modal-area*/
    const closeModal = document.querySelectorAll(`#close-${modalId}`);
    closeModal.forEach(e => {
        e.addEventListener('click', function(){
            const classModalArea = document.querySelector(`.modal-area-${modalId}`);
            classModalArea.remove();
        });
    })
    /** URL */
    if (others.url || others.url != ""){
        let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //Set default headers
        let headers = {
            method: 'POST', // *GET, POST, PUT, DELETE, etc.
            credentials: "same-origin",
            body: others.data,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        }
        //Init type request
        headers.headers['X-Requested-With'] = 'XMLHttpRequest';
        headers.headers['X-CSRF-TOKEN'] = csrf;
        const response = await fetch(others.url, headers);
        
    }
}