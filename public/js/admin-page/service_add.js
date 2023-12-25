ClassicEditor.create(document.querySelector("#description"), {
    toolbar: [
        "heading",
        "|",
        "bold",
        "italic",
        "link",
        "bulletedList",
        "numberedList",
        "blockQuote",
    ],
    heading: {
        options: [
            {
                model: "paragraph",
                title: "Paragraph",
                class: "ck-heading_paragraph",
            },
            {
                model: "heading1",
                view: "h1",
                title: "Heading 1",
                class: "ck-heading_heading1",
            },
            {
                model: "heading2",
                view: "h2",
                title: "Heading 2",
                class: "ck-heading_heading2",
            },
        ],
    },
}).catch((error) => {
    console.log(error);
});

const img_service = document.getElementById("img_service");
let blah = document.getElementById("blah");
img_service.onchange = (evt) => {
    const [file] = img_service.files;
    if (file) {
        blah.src = URL.createObjectURL(file);
    }
};
