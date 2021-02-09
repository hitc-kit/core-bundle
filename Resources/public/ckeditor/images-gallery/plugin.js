CKEDITOR.plugins.add('imagesgallery', {
    lang: 'ru,en',

    init: function(editor) {
        let sourcePath = CKEDITOR.plugins.getPath('imagesgallery') + 'templates/images_gallery.js';
        CKEDITOR.config.templates_files.push(sourcePath);
    }
});
