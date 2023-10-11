

function storeInformation(data){

    axios({
        method: "post",
        url: "../../student/courses/class-5",
        data: JSON.stringify(data),
        headers: {
            "Content-Type": "application/json",
        }
    }).then(function (response) {
        console.log(response.data);
    }).catch(function (response) {
        console.log(response);
    });
}

//delete
