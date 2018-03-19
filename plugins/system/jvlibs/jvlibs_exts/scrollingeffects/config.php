{
    name: 'Scrolling effects',
    version: '1.0.0',
    config: {
        applys:{
            field: 'multi',
            label: 'Applys',
            item:{
                field: 'group',
                label: 'Config effect',
                toggle: true,
                titlefield: 'selector',
                item: {
                    mobile: {
                        field: "input", type: "checkbox",
                        label: 'Enable on mobile',
                        value: true
                    },
                    selector: {
                        field: 'input',
                        label: 'Selector',
                        validates:{required:true}
                    },
                    duration: {
                        field: 'input',
                        label: 'Duration',
                        value: 500,
                        validates:{number:true}
                    },
                    delay: {
                        field: 'input',
                        label: 'Delay',
                        value: 0,
                        validates:{number:true}
                    },
                    offset: {
                        field: 'input',
                        label: 'Offset',
                        value: 0,
                        validates:{number:true}
                    },
                    iteration: {
                        field: 'input',
                        label: 'Iteration',
                        value: 0,
                        validates:{number:true}
                    },
                    effect: {
                        field: 'select2',
                        label: 'Effect',
                        //maximumSelectionSize: 1,
                        query: function (query) {
                            var data = {results: []},$=jQuery;
                            query.term && data.results.push({id: query.term, text: query.term});
                            $.each(this.item,function(k,v){
                                //if(query.term || )
                                //data.results.push({id: k, text: k});
                                var children = [];
                                $.each(v,function(k,v){
                                    if(!query.term || k.toLowerCase().indexOf(query.term.toLowerCase()) > -1)
                                        children.push({id: k, text: v});
                                });
                                children.length && data.results.push({text: k, children:children});
                            });
                            query.callback(data);
                        },
                        validates:{required:true},
                        item:{
                            "Attention Seekers": {
                                "bounce": "bounce",
                                "flash": "flash",
                                "pulse": "pulse",
                                "rubberBand": "rubberBand",
                                "shake": "shake",
                                "swing": "swing",
                                "tada": "tada",
                                "wobble": "wobble"
                            },

                            "Bouncing Entrances": {
                                "bounceIn": "bounceIn",
                                "bounceInDown": "bounceInDown",
                                "bounceInLeft": "bounceInLeft",
                                "bounceInRight": "bounceInRight",
                                "bounceInUp": "bounceInUp"
                            },

                            "Bouncing Exits": {
                                "bounceOut": "bounceOut",
                                "bounceOutDown": "bounceOutDown",
                                "bounceOutLeft": "bounceOutLeft",
                                "bounceOutRight": "bounceOutRight",
                                "bounceOutUp": "bounceOutUp"
                            },

                            "Fading Entrances": {
                                "fadeIn": "fadeIn",
                                "fadeInDown": "fadeInDown",
                                "fadeInDownBig": "fadeInDownBig",
                                "fadeInLeft": "fadeInLeft",
                                "fadeInLeftBig": "fadeInLeftBig",
                                "fadeInRight": "fadeInRight",
                                "fadeInRightBig": "fadeInRightBig",
                                "fadeInUp": "fadeInUp",
                                "fadeInUpBig": "fadeInUpBig"
                            },

                            "Fading Exits": {
                                "fadeOut": "fadeOut",
                                "fadeOutDown": "fadeOutDown",
                                "fadeOutDownBig": "fadeOutDownBig",
                                "fadeOutLeft": "fadeOutLeft",
                                "fadeOutLeftBig": "fadeOutLeftBig",
                                "fadeOutRight": "fadeOutRight",
                                "fadeOutRightBig": "fadeOutRightBig",
                                "fadeOutUp": "fadeOutUp",
                                "fadeOutUpBig": "fadeOutUpBig"
                            },

                            "Flippers": {
                                "flip": "flip",
                                "flipInX": "flipInX",
                                "flipInY": "flipInY",
                                "flipOutX": "flipOutX",
                                "flipOutY": "flipOutY"
                            },

                            "Lightspeed": {
                                "lightSpeedIn": "lightSpeedIn",
                                "lightSpeedOut": "lightSpeedOut"
                            },

                            "Rotating Entrances": {
                                "rotateIn": "rotateIn",
                                "rotateInDownLeft": "rotateInDownLeft",
                                "rotateInDownRight": "rotateInDownRight",
                                "rotateInUpLeft": "rotateInUpLeft",
                                "rotateInUpRight": "rotateInUpRight"
                            },

                            "Rotating Exits": {
                                "rotateOut": "rotateOut",
                                "rotateOutDownLeft": "rotateOutDownLeft",
                                "rotateOutDownRight": "rotateOutDownRight",
                                "rotateOutUpLeft": "rotateOutUpLeft",
                                "rotateOutUpRight": "rotateOutUpRight"
                            },

                            "Sliders": {
                                "slideInDown": "slideInDown",
                                "slideInLeft": "slideInLeft",
                                "slideInRight": "slideInRight",
                                "slideOutLeft": "slideOutLeft",
                                "slideOutRight": "slideOutRight",
                                "slideOutUp": "slideOutUp"
                            },

                            "Specials": {
                                "hinge": "hinge",
                                "rollIn": "rollIn",
                                "rollOut": "rollOut"
                            }
                        }
                    }
                }
            }
        }
    }
}