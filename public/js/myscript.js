// load user avatar into image tag
var loadImage = function (event) {
    var previewElement = document.getElementById('preview');
    previewElement.src = URL.createObjectURL(event.target.files[0]);
}

// remove image 
var removeImage = function (event) {
    var avatar = document.getElementById('avatar');
    var previewElement = document.getElementById('preview');
    avatar.value = null;
    previewElement.src = "";

}

var setAgeLimit = function(event) {
    let selected = document.getElementById('usertype').value;
    alert(selected);
}

// set emergency flag true when it's checked
document.getElementById('emergency_flag').addEventListener('change', function(e) {
    var ef = document.getElementById('emergency_flag');
    if(ef.value == null || ef.value == false)
        ef.value = true;
    else 
        ef.value = false;
})

// toggle emergency checkbox
var toggleEmergency = function (event) {
    var emergencyBlock = document.getElementById('emergency-block');
    const selectedDate = new Date(event.target.value);
    // Get today's date
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Reset hours, minutes, seconds, and milliseconds for accurate comparison.

    if (selectedDate.toDateString() === today.toDateString()) {
        emergencyBlock.style = 'display:flex;';
    } else {
        emergencyBlock.style = 'display:none;';
    }
}

var activeTab = function (tabIndex) {

    alert('working');
    // Get all tabs and panels
    var tabs = document.querySelectorAll('#tab');

    // Remove the 'active' class from all tabs and panels
    tabs.forEach(function (tab) {
        tab.classList.remove('bg-blue-500 text-white');
    });

    // Add the 'active' class to the clicked tab and its associated panel
    tabs[tabIndex].classList.add('bg-blue-500 text-white');
}