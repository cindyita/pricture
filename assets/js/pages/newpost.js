var toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike'],
  ['blockquote', 'code-block'],

  [{ 'header': 1 }, { 'header': 2 }], 
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
  [{ 'script': 'sub'}, { 'script': 'super' }],
  [{ 'indent': '-1'}, { 'indent': '+1' }], 
  [{ 'direction': 'rtl' }], 

  [{ 'size': ['small', false, 'large', 'huge'] }],
  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

  [{ 'color': [] }, { 'background': [] }],
  [{ 'font': [] }],
  [{ 'align': [] }],

  ['clean']
];

var quill = new Quill('#text-post', {
  modules: {
    toolbar: toolbarOptions
  },
  theme: 'snow'
});



$(document).ready(function () {

    $('#newPost').submit(function (event) {

        event.preventDefault();

        $("#text-post-input").val(quill.root.innerHTML);
        
        var formData = new FormData(this);
        $.ajax({
            url: './src/controllers/actionsController.php?action=newPost',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res == 1 || res == 11) {
                    message("success", "Your post has been uploaded successfully");
                    window.location = "myposts";
                } else {
                    message("error", "There was an error");
                    console.log(res);
                }
                
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud. Código de estado: ' + xhr.status);
            }
        });

    });

});