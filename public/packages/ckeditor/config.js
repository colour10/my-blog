// 配置文件
CKEDITOR.editorConfig = function (config) {
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    // config.uiColor = '#AADC6E';
    config.toolbarGroups = [
        {name: 'clipboard', groups: ['clipboard', 'undo']},
        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
        {name: 'forms', groups: ['forms']},
        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
        {name: 'paragraph', groups: ['list', 'indent', 'blocks', 'align', 'bidi', 'paragraph']},
        {name: 'links', groups: ['links']},
        {name: 'insert', groups: ['insert']},
        {name: 'styles', groups: ['styles']},
        {name: 'colors', groups: ['colors']},
        {name: 'document', groups: ['document', 'doctools', 'mode']},
        {name: 'tools', groups: ['tools']},
        {name: 'others', groups: ['others']},
        {name: 'about', groups: ['about']}
    ];

    //移除的按钮
    config.removeButtons = 'Templates,Print,Find,Replace,SelectAll,Scayt,Checkbox,Form,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Blockquote,BidiLtr,BidiRtl,Flash,PageBreak,Iframe,About,ShowBlocks,Smiley,SpecialChar,HorizontalRule,CopyFormatting,RemoveFormat';

    //上传图片窗口用到的接口
    config.filebrowserImageUploadUrl = "/admin/upload";
    config.filebrowserUploadUrl = "/admin/upload";

    // 使上传图片弹窗出现对应的“上传”tab标签
    config.removeDialogTabs = 'image:advanced;link:advanced';

    //粘贴图片时用得到
    config.extraPlugins = 'uploadimage';
    config.uploadUrl = '/_@admin@_/upload';
};
