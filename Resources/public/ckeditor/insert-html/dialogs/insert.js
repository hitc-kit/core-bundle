CKEDITOR.dialog.add('insertDialog', function(editor) {
    let lang = editor.lang.inserthtml;

    return {
        title: lang.dialogTitle,
        minWidth: 600,
        minHeight: 200,
        contents: [
            {
                id: 'insert-html-tab',
                elements: [
                    {
                        type: 'textarea',
                        rows: 20,
                        id: 'insert-html-code',
                        label: lang.labelYourCode,
                        'default': '',
                        validate: CKEDITOR.dialog.validate.notEmpty( "HTML code field cannot be empty." )
                    }
                ]
            }
        ],
        onOk: function () {
            editor.insertHtml(this.getValueOf('insert-html-tab', 'insert-html-code'));
        }
    };
});
