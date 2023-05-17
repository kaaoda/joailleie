function deleteModel (url, trElement = null) {
    if (axios) {
        axios.delete(url)
        .then(response => {
            console.log(response);
            if(trElement) trElement.remove()
            iziToast.success({
                title: 'Success',
                message: response.data.success,
                position: 'topRight'
            });
        })
        .catch(err => {
            console.log(err);
            iziToast.warning({
                title: 'Error!',
                message: err.response.data.error,
                position: 'topRight'
            });
        })
    }
}