$(function () {
    console.log("page ready");
});

function changeUsername() {
    const username = document.getElementById("username").value;
    const usnm = username.replaceAll(" ", "_");
    console.log(usnm);
    document.getElementById("username").value = usnm.toLowerCase();
}

function generateUsername() {
    const fullname = document.getElementById("fullname").value;
    const username = document.getElementById("username");
    const usnm = fullname.replace(" ", "_");

    username.value = usnm.substring(0, 10).toLowerCase();
}

var invalid = document.getElementById("invalid").value;
console.log(invalid);
var valid = document.getElementById("valid").value;
if (valid) {
} else if (invalid) {
}

const image = document.getElementById("image");
let blah = document.getElementById("blah");
image.onchange = (evt) => {
    const [file] = image.files;
    if (file) {
        blah.src = URL.createObjectURL(file);
    }
};
