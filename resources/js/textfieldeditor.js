import {
    ClassicEditor,
} from '@ckeditor/ckeditor5-editor-classic';
import {
    Essentials,
} from '@ckeditor/ckeditor5-essentials';
import {
    Autoformat,
} from '@ckeditor/ckeditor5-autoformat';
import {
    Bold,
    Code,
    Italic,
    Strikethrough,
    Subscript,
    Superscript,
    Underline,
} from '@ckeditor/ckeditor5-basic-styles';
import {
    BlockQuote,
} from '@ckeditor/ckeditor5-block-quote';
import {
    Heading,
} from '@ckeditor/ckeditor5-heading';
import {
    Link, LinkImage,
} from '@ckeditor/ckeditor5-link';
import {
    List,
} from '@ckeditor/ckeditor5-list';
import {
    Paragraph,
} from '@ckeditor/ckeditor5-paragraph';
import {
    Image,
    ImageCaption,
    ImageStyle,
    ImageToolbar,
    ImageInsert,
    AutoImage,
    ImageResize,
    ImageUpload,
} from '@ckeditor/ckeditor5-image';
import {
    Alignment,
} from '@ckeditor/ckeditor5-alignment';
import { MediaEmbed } from '@ckeditor/ckeditor5-media-embed';
import { Indent } from '@ckeditor/ckeditor5-indent';
import { PasteFromOffice } from '@ckeditor/ckeditor5-paste-from-office';
import {
    Table,
    TableCaption,
    TableCellProperties,
    TableColumnResize,
    TableProperties,
    TableToolbar,
} from '@ckeditor/ckeditor5-table';
import { TextTransformation } from '@ckeditor/ckeditor5-typing';
import { CKFinder } from '@ckeditor/ckeditor5-ckfinder';
import CKFinderUploadAdapter from '@ckeditor/ckeditor5-adapter-ckfinder/src/uploadadapter';
import { Markdown } from '@ckeditor/ckeditor5-markdown-gfm';
import { Font } from '@ckeditor/ckeditor5-font';
import { Highlight } from '@ckeditor/ckeditor5-highlight';
import { SelectAll } from '@ckeditor/ckeditor5-select-all';
import { RemoveFormat } from '@ckeditor/ckeditor5-remove-format';
import { SourceEditing } from '@ckeditor/ckeditor5-source-editing';
import { PageBreak } from '@ckeditor/ckeditor5-page-break';
import { FindAndReplace } from '@ckeditor/ckeditor5-find-and-replace';
import { HorizontalLine } from '@ckeditor/ckeditor5-horizontal-line';
import { Minimap } from '@ckeditor/ckeditor5-minimap';
import { Base64UploadAdapter } from '@ckeditor/ckeditor5-upload';
import { CodeBlock } from '@ckeditor/ckeditor5-code-block';

function createWYSIWYG(target, config, callback) {
    if (typeof target === 'string') {
        const eleditor = document.querySelector(target);
        if (eleditor) {
            let cfg = {
                plugins: [
                    Alignment,
                    Autoformat,
                    AutoImage,
                    Base64UploadAdapter,
                    BlockQuote,
                    Bold,
                    CKFinder,
                    CKFinderUploadAdapter,
                    Code,
                    CodeBlock,
                    Essentials,
                    FindAndReplace,
                    Font,
                    Heading,
                    Highlight,
                    HorizontalLine,
                    Image,
                    ImageCaption,
                    ImageInsert,
                    ImageStyle,
                    ImageToolbar,
                    ImageResize,
                    ImageUpload,
                    Indent,
                    Italic,
                    Link,
                    LinkImage,
                    List,
                    MediaEmbed,
                    // Markdown,
                    // Minimap,
                    PageBreak,
                    Paragraph,
                    PasteFromOffice,
                    RemoveFormat,
                    SelectAll,
                    SourceEditing,
                    Strikethrough,
                    Superscript,
                    Subscript,
                    Table,
                    TableCaption,
                    TableCellProperties,
                    TableColumnResize,
                    TableProperties,
                    TableToolbar,
                    TextTransformation,
                    Underline,
                ],
                toolbar: {
                    items: [
                        'undo',
                        'redo',
                        '|',
                        'alignment',
                        'heading',
                        '|',
                        'sourceEditing',
                        'findAndReplace',
                        '|',
                        'fontSize',
                        'fontFamily',
                        'fontColor',
                        'fontBackgroundColor',
                        '|',
                        'highlight',
                        '|',
                        'bold',
                        'italic',
                        'underline',
                        {
                            label: 'Formatting',
                            icon: 'text',
                            items: [ 'strikethrough', 'subscript', 'superscript', 'code', 'horizontalLine', '|', 'removeFormat' ]
                        },
                        '|',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'outdent',
                        'indent',
                        'insertImage',
                        'mediaEmbed',
                        'selectAll',
                        'blockQuote',
                        'insertTable',
                        'pageBreak',
                    ],
                },
                language: 'en',
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'toggleImageCaption',
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side',
                        'resizeImage',
                        'linkImage',
                    ],
                    insert: {
                        integrations: [
                            'insertImageViaUrl'
                        ],
                    },
                    resizeOptions: [
                        {
                            name: 'resizeImage:original',
                            value: null,
                            label: 'Original'
                        },
                        {
                            name: 'resizeImage:40',
                            value: '40',
                            label: '40%'
                        },
                        {
                            name: 'resizeImage:60',
                            value: '60',
                            label: '60%'
                        }
                    ],
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells',
                        'tableProperties',
                        'tableCellProperties',
                        'toggleTableCaption',
                    ],
                },
            };
            if (typeof config === 'object') {
                cfg = Object.assign(cfg, config);
            }
            ClassicEditor.create(eleditor, cfg).then((editor) => {
                if (typeof callback === 'function') {
                    callback(editor);
                }
            });
        }
    }
}

window.createTextEditor = createWYSIWYG;
