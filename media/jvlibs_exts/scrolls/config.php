{
    "name": "Scrolls",
    "version": "1.0.0",
    "config": {
        "config": {
            "label": "Scrolls",
            "class": "none",
            "field": "multi",
            "filter": true,
            "item": {
                "field": "group",
                "toggle": true,
                "titlefield":"selector",
                "item":{
                    "selector":{
                        "field": "input",
                        "label": "Assign",
                        "validates": {"required": true},
                        "title":"Input selector. <br/> Ex: #myid, .myclass ..."
                    },
                    "railvalign":{
                        "field": "select2",
                        "label": "Vertical scroll",
                        "value": "bottom",
                        "item": {
                            
                            "bottom": "Display at bottom",
                            "top": "Display at top"
                        }
                    },
                    "railalign":{
                        "field": "select2",
                        "label": "Horizontal scroll",
                        "value": "right",
                        "item": {
                            "right": "Display at right",
                            "left": "Display at left"
                        }
                    },
                    "autohidemode":{
                        "field": "select2",
                        "label": "Auto hide mode",
                        "value": "true",
                        "item": {
                            "true": "true",
                            "false": "false"
                        }
                    },
                    "width": {
                        "field": "input",
                        "label": "Fix width"
                    },
                    "height": {
                        "field": "input",
                        "label": "Fix height"
                    },
                    "scrollspeed": {
                        "field": "input",
                        "label": "Scroll speed",
                        "value": 60,
                        "validates":{ "number": true, "required": true }
                    },
                    "cursorcolor": {
                        "field": "color",
                        "label": "Cursor color",
                        "value": "#424242"
                    },
                    "background": {
                        "field": "color",
                        "label": "Background",
                        "value": ""
                    }
                }
            }
        }
    }
}