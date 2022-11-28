import axios from 'axios';
console.log('goooo')
window.trackProduct = (product_id) => {
    let data = new FormData();
    let button = document.getElementById(product_id)
    button.disabled = true;
    button.innerText = 'Loading...';
    data.append('_token', csrf);
    axios({
        method: 'post',
        url: `${base_url}${product_id}`,
        data: data,
        headers: { 'Content-type': 'multipart/form-data' }
    })
    .then(response => {
        if (response.status === 200) {
            button.innerText = 'Tracking';
            button.classList = button.classList + ' bg-green-300 border-green-500';
        }
    })
}