/**
 * Settings for summernote editor.
 */

$(document).ready(function () {

    $(document).ready(function () {

        const editor = $('#short_content');
        const editor_full = $('#content');

        var configFull = {
            lang: 'uk-UA', // default: 'en-US'
            shortcuts: false,
            airMode: false,
            minHeight: 150, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false, // set focus to editable area after initializing summernote
            disableDragAndDrop: false,
            callbacks: {
                onImageUpload: function (files) {
                   uploadFile(files, editor);
                },

                onMediaDelete: function ($target, editor, $editable) {

                    var fileURL = $target[0].src;
                    deleteFile(fileURL);

// remove element in editor
                    $target.remove();
                }
            }
        };

        const editorConfigContent = {
            lang: 'uk-UA', // default: 'en-US'
            shortcuts: false,
            airMode: false,
            minHeight: 210, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true, // set focus to editable area after initializing summernote
            disableDragAndDrop: false,
            callbacks: {
            onImageUpload: function (files) {
                uploadFile(files, editor_full);
            },

            onMediaDelete: function ($target, editor, $editable) {

                var fileURL = $target[0].src;
                deleteFile(fileURL);

// remove element in editor
                $target.remove();
            }
        }
    };

// Featured editor
        editor.summernote(configFull);
        editor_full.summernote(editorConfigContent);

// Upload file on the server.
        function uploadFile(filesForm, editor) {
            data = new FormData();
            for (var i = 0; i < filesForm.length; i++) {
                data.append("image", filesForm[i]);
            }

            $.ajax({
                data: data,
                type: "POST",
                url: "/ajax/upload/image",
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                contentType: false,
                processData: false,
                success: function (images) {
                    if (images.ok) {
                        console.log(images.data.path)
                        editor.summernote('insertImage', images.data.path, function ($image) {
                            //$image.css('width', $image.width() / 3);
                            //$image.attr('data-filename', 'retriever')
                        });
                    } else {
                        console.error('Error upload file');
                    }
                }
            });
        }

// Delete file from the server.
        function deleteFile(file) {
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: "/ajax/uploader/delete",
                cache: false,
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                contentType: false,
                processData: false,
                success: function (image) {
//console.log(image);
                }
            });
        }

    });

});
