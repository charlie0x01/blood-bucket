var loadImage = function(event) {
    var previewElement = document.getElementById('preview');
    previewElement.src = URL.createObjectURL(event.target.files[0]);
}

var removeImage= function(event) {
    var avatar = document.getElementById('avatar');
    var previewElement = document.getElementById('preview');
    avatar.value = null;
    previewElement.src = "";

}


document.getElementById('usertype').addEventListener('change', event => {
    alert(event.options[event.selectedIndex].text);
})

var age = document.getElementById('age').addEventListener('blur', event => {
    alert(event.target.value);
})