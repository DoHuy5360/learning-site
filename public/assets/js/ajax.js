class AJAX {
    constructor() {
        this.url_protocol = window.location.origin;
        this.url_hostname = window.location.origin;
        this.url_port = window.location.origin;
        this.url_host = window.location.origin;
        this.url_pathname = window.location.origin;
        this.url_origin = window.location.origin;
        this.url_href = window.location.href;
    }
    /**
     * @param {String} _method Phương thức GET, POST
     * @param {String} _path Tên của luồng đi /route
     * @param {Function} _callback Đối sô là Response
     */
    createAjax(_method, _path, _form, _callback) {
        const ajax = new XMLHttpRequest();
        ajax.open(_method, this.url_origin + _path);
        ajax.send(_form);
        ajax.onreadystatechange = function () {
            if (
                this.status == 200 &&
                this.readyState == 4 &&
                this.responseText
            ) {
                const data_response = JSON.parse(this.responseText);
                _callback(data_response);
            }
        };
    }
    /**
     * @param {String} _node_id Chỉ nhận Id của Node muốn chèn HTML vào
     * @param {Array} _response Mảng chứa các đối tượng [ { }, { }, ... ]
     * @param {Function} _createHtml Tên của 1 hàm mà nó trả về HTML
     */
    insertResponseToNodeId(_node_id, _response, _createHtml) {
        const node_id = document.getElementById(_node_id);
        _response.forEach((object_data) => {
            const html = _createHtml.call(object_data);
            node_id.insertAdjacentHTML("beforeend", html);
        });
    }
}
