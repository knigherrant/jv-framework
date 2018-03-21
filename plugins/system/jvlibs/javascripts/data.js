{
    "jquery":{
        "js": "jquery/jquery.min.js,jquery/noconflict.js",
        "bootstrap": {
            "require": "jquery",
            "js": "jquery/bootstrap/bootstrap.js,jquery/bootstrap/bootstrap.mootools-fix.js",
            "css": "jquery/bootstrap/css/bootstrap.min.css,jquery/bootstrap/css/bootstrap-theme.min.css",
            "select": {
                "require": "jquery.bootstrap",
                "js": "jquery/bootstrap/bootstrap-select.min.js",
                "css": "jquery/bootstrap/css/bootstrap-select.min.css"
            },
            "select2": {
                "require": "jquery.bootstrap",
                "js": "jquery/bootstrap/select2.js",
                "css": "jquery/bootstrap/css/select2.css"
            }
        },
        "ui": {
            "core": {
                "require": "jquery",
                "js": "jquery/ui/jquery-ui.core.min.js",
                "css": "jquery/ui/css/no-theme/jquery-ui-1.10.3.custom.min.css"
            },
            "effects":{ 
                "require": "jquery",
                "js": "jquery/ui/jquery-ui.effects.min.js"
            },
            "interactions": {
                "require": "jquery.ui.core",
                "js": "jquery/ui/jquery-ui.interactions.min.js"
            },
            "widget": {
                "require": "jquery.ui.interactions",
                "js": "jquery/ui/jquery-ui.widget.min.js"
            }
        },
        "plugins":{
            "colorpicker": {
                "require": "jquery.bootstrap",
                "js": "jquery/plugins/colorpicker/bootstrap-colorpicker.js",
                "css": "jquery/plugins/colorpicker/css/bootstrap-colorpicker.css"
            },
            "combobox": {
                "require": "jquery.bootstrap",
                "js": "jquery/plugins/combobox/bootstrap-combobox.js",
                "css": "jquery/plugins/combobox/bootstrap-combobox.css"
            },
            "datetimepicker": {
                "require": "jquery.bootstrap",
                "js": "jquery/plugins/datetimepicker/bootstrap-datetimepicker.min.js",
                "css": "jquery/plugins/datetimepicker/bootstrap-datetimepicker.min.css"
            },
            "customfield": {
                "require": "jquery.plugins.colorpicker,jquery.plugins.datetimepicker,jquery.ui.interactions,jquery.bootstrap.select2,jquery.plugins.imagesloaded",
                "js": "jquery/plugins/customfield/customfield.js",
                "css": "jquery/plugins/customfield/style.css"
            },
            "mousewheel":{
                "require": "jquery",
                "js": "jquery/plugins/jquery.mousewheel.min.js"
            },
            "hotkey":{
                "require": "jquery",
                "js": "jquery/plugins/jquery.hotkey.js"
            },
            "touchswipe":{
                "require": "jquery",
                "js": "jquery/plugins/jquery.touchSwipe.min.js"
            },
            "validate":{
                "require": "jquery",
                "js": "jquery/plugins/jquery.validate.js"
            },
            "masonry":{
                "require": "jquery",
                "js": "jquery/plugins/jquery.masonry.min.js"
            },
            "imagesloaded":{
                "require": "jquery",
                "js": "jquery/plugins/jquery.imagesloaded.js"
            },
            "fieldselection":{
                "require": "jquery",
                "js": "jquery/plugins/jquery-fieldselection.min.js"
            },
            "transform":{
                "require": "jquery",
                "js": "jquery/plugins/transformjs.1.0.beta.2.min.js"
            },
            "history":{
                "require": "jquery",
                "js": "jquery/plugins/jquery.history.min.js"
            }
        }
    }
}