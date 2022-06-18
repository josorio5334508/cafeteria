/* A shorthand for `document.querySelector()` */
const d = document;

d.addEventListener("DOMContentLoaded", (e) => {

    const $productList = d.querySelector(".product-list"),
    $form = d.querySelector(".form-product-create"),
    $input = d.querySelectorAll(".form-product-create [data-obligatorio]");

    const productList = async () => {
        try{
            let options = {
                method: 'GET',
                headers: {'Content-Type': 'application/json'}
            },
            res = await fetch('/product/list', options),
            json = await res.json();

            if(!res.ok) throw { status: res.status, statusText: res.statusText };

            let html = '';
            json.data.forEach((el) => {
                html += `<tr>
                            <td>${el.id }</td>
                            <td>${el.nombre }</td>
                            <td>${el.referencia }</td>
                            <td>${el.precio }</td>
                            <td>${el.peso }</td>
                            <td>${el.categoria }</td>
                            <td>${el.stock }</td>
                            <td>${el.fecha_creacion }</td>
                            <td>
                                <button class="btn btn-warning btn-edit" data-id="${ el.id }" data-nombre="${ el.nombre }" data-referencia="${ el.referencia }" data-precio="${ el.precio }" data-peso="${ el.peso }" data-categoria="${ el.categoria }" data-stock="${ el.stock }" data-fecha_creacion="${ el.fecha_creacion }" data-bs-toggle="modal" data-bs-target="#modalProduct">Editar</button>
                                <button class="btn btn-danger btn-delete" data-id="${ el.id }">Eliminar</button>
                            </td>
                        </tr>`
            })

            $productList.innerHTML = await html

        }catch(err) {
            let message = err.statusText || 'Ocurrió un error';
            $productList.innerHTML = `<tr><td colspan="8">ñ{lñ{lñ</td></tr>`;
        }

    }
    productList()

    /* Listening for a click event on the document. */
    d.addEventListener("click", async (e) => {
        if(e.target.matches(".btn-edit")){
            d.querySelector("#modalProductLabel").textContent = 'Editar producto'
            $form.id.value = e.target.dataset.id
            $form.nombre.value = e.target.dataset.nombre
            $form.referencia.value = e.target.dataset.referencia
            $form.precio.value = e.target.dataset.precio
            $form.peso.value = e.target.dataset.peso
            $form.categoria.value = e.target.dataset.categoria
            $form.stock.value = e.target.dataset.stock
            $form.fecha_creacion.value = e.target.dataset.fecha_creacion
        }

        if(e.target.matches(".btn-create")){
            d.querySelector("#modalProductLabel").textContent = 'Crear producto'
            $form.reset()
        }

        if(e.target.matches(".btn-delete")){
            try{
                let options = {
                    method: "DELETE",
                    headers: {
                        'Content-Type': 'application/json; charset=utf-8'
                    },
                    body: JSON.stringify({_token: token})
                }
                let res = await fetch('/product/delete/'+e.target.dataset.id, options),
                json = await res.json();

                console.log(json)

                if(!res.ok) throw { status: res.status, statusText: res.statusText };
                d.querySelector(".message-delete").innerHTML = json.msg;
                productList()
            }catch(err) {
                let message = err.statusText || 'Ocurrió un error';
                alert(`Error ${err.status}: ${message}`)
            }
        }

    })

    $input.forEach((input) => {
        const $span = d.createElement("span")
        $span.id = input.name
        $span.textContent = input.title
        $span.classList.add('text-danger')
        $span.setAttribute('hidden', 'true')
        input.insertAdjacentElement("afterend", $span)
    })

    d.addEventListener("keyup", (e) => {
        if(e.target.matches(".form-product-create [data-obligatorio]")){
            let $input = e.target
            return ($input.value == "")
                ? d.getElementById($input.name).removeAttribute('hidden')
                : d.getElementById($input.name).setAttribute('hidden', 'true');
        }
    })

    d.addEventListener("submit", async (e) => {
        e.preventDefault();

        if(e.target.matches(".form-product-create")){
            try {
                const $inputList = d.querySelectorAll(".form-product-create [data-obligatorio]")
                let fieldEmpty = true
                $inputList.forEach((input) => {
                    if(input.value == ""){
                        d.getElementById(input.name).removeAttribute("hidden")
                        fieldEmpty = true
                    }else{
                        fieldEmpty = false
                        d.getElementById(input.name).setAttribute("hidden", "true")
                    }
                })

                if(fieldEmpty === false){

                        let formData = new FormData(e.target);
                        formData.append('_token', token)

                    if(e.target.id.value == ""){
                        // IINSERT
                        let options = {
                            method: "POST",
                            body: formData
                        }

                        let res = await fetch(url_create, options),
                        json = await res.json()

                        if(!res.ok) throw { status: res.status, statusText: res.statusText };

                        e.target.reset();
                        productList()
                        d.querySelector(".message").innerHTML = `<div class="alert alert-success mb-2">${json.msg}</div>`

                        setTimeout(() => { d.querySelector(".message").innerHTML = `` }, 3000)
                    }else{
                        // UPDATE
                        let options = {
                            method: "POST",
                            body: formData
                        }

                        let res = await fetch(`${url_update}`, options),
                        json = await res.json()

                        if(!res.ok) throw { status: res.status, statusText: res.statusText };

                        e.target.reset();
                        productList()
                        d.querySelector(".message").innerHTML = `<div class="alert alert-success mb-2">${json.msg}</div>`

                        setTimeout(() => { d.querySelector(".message").innerHTML = `` }, 3000)
                    }
                }
            }catch (err) {
                let message = err.statusText || 'Ocurrió un error '+err;
                d.querySelector(".message").innerHTML = `<div class="alert alert-danger mb-2">${message}</div>`

                setTimeout(() => { d.querySelector(".message").innerHTML = `` }, 5000)
            }
        }

    })

})