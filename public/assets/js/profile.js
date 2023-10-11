function display_images(file){
    let allowedExtention = ['jpg', 'jpeg' ,'png','webp'];
     let ext = file.name.split('.').pop();
     console.log(ext)
     if(!allowedExtention.includes(ext.toLowerCase())){
        alert('The file you tried to upload is no a ' + allowedExtention.toString(" , "))
     }
    console.log( file.name)
   let img =  document.querySelector('.profile-img').src = URL.createObjectURL(file) ;
   console.log( URL.createObjectURL(file) )

}