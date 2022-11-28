import axios from 'axios';
console.log('goooo')
window.trackProduct = (product_id) => {
    let data = new FormData();
    data.append('_token', csrf);
    axios({
        method: 'post',
        url: `${base_url}${product_id}`,
        data: data,
        headers: { 'Content-type': 'multipart/form-data' }
    })
    .then(response => {
        console.log("Response:");
        console.log(response);
    })
}