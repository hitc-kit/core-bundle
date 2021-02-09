CKEDITOR.plugins.add('inserthtml', {
    lang: 'ru,en',
    icons: 'insert',

    init: function(editor) {
        editor.addCommand('insert', new CKEDITOR.dialogCommand( 'insertDialog' ));

        editor.ui.addButton('Insert', {
            label: editor.lang.inserthtml.labelButton,
            command: 'insert',
            toolbar: 'insert,100',
            icon: this.path + 'icons/insert.png'
        });

        CKEDITOR.dialog.add('insertDialog', this.path + 'dialogs/insert.js');
        CKEDITOR.dtd.$removeEmpty['i'] = false;
    }
});
