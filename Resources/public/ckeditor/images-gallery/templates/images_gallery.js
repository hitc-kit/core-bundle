let lang = CKEDITOR.currentInstance.lang.imagesgallery;
let path = CKEDITOR.getUrl(CKEDITOR.plugins.getPath( 'imagesgallery' ) + 'templates/images/' );

CKEDITOR.addTemplates('images_gallery', {
    imagesPath: path,

    templates: [{
        title: lang.galleryTitle,
        description: lang.galleryDescription,
        image: 'gallery.gif',
        html:
            '<div class="mb-3">' +
                '<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 m-n2">' +
                    '<div class="col p-2">' +
                        '<div class="img-thumbnail">' +
                            '<a href="' + path + 'your_image.png" data-fancybox="gallery" class="row align-items-center justify-content-center no-gutters" style="height: 200px;">' +
                                '<img src="' + path + 'your_image.png" class="col-auto mw-100 mh-100" alt="...">' +
                            '</a>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col p-2">' +
                        '<div class="img-thumbnail">' +
                            '<a href="' + path + 'your_image.png" data-fancybox="gallery" class="row align-items-center justify-content-center no-gutters" style="height: 200px;">' +
                                '<img src="' + path + 'your_image.png" class="col-auto mw-100 mh-100" alt="...">' +
                            '</a>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col p-2">' +
                        '<div class="img-thumbnail">' +
                            '<a href="' + path + 'your_image.png" data-fancybox="gallery" class="row align-items-center justify-content-center no-gutters" style="height: 200px;">' +
                                '<img src="' + path + 'your_image.png" class="col-auto mw-100 mh-100" alt="...">' +
                            '</a>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col p-2">' +
                        '<div class="img-thumbnail">' +
                            '<a href="' + path + 'your_image.png" data-fancybox="gallery" class="row align-items-center justify-content-center no-gutters" style="height: 200px;">' +
                                '<img src="' + path + 'your_image.png" class="col-auto mw-100 mh-100" alt="...">' +
                            '</a>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>'
    }, {
        title: lang.imageTitle,
        description: lang.imageDescription,
        image: 'gallery.gif',
        html:
            '<div class="col p-2">' +
                '<div class="img-thumbnail">' +
                    '<a href="' + path + 'your_image.png" data-fancybox="gallery" class="row align-items-center justify-content-center no-gutters" style="height: 200px;">' +
                        '<img src="' + path + 'your_image.png" class="col-auto mw-100 mh-100" alt="...">' +
                    '</a>' +
                '</div>' +
            '</div>'
    }]
});
