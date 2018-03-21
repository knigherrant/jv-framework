{
    name: 'Load content',
    version: '1.0.0',
    config: {
        modalwidth:{
            label: 'Default modal width',
            field: 'input',
            value: 500
        },
        access:{
            label: 'Access to load content function',
            field: 'multi',
            'class': 'none',
            toggle: true,
            filter: true,
            item: {
                call:{
                    label: 'Define function',
                    field: 'input',
                    validates:{
                        required: true,
                        reg: /^[a-zA-Z]+([a-zA-Z]|\d)*(::[a-zA-Z]+([a-zA-Z]|\d)*)?$/
                    },
                    placeholder: 'JVLoadContent::example'
                },
                access:{
                    label: 'Access level',
                    field: 'select',
                    value: 'publish',
                    item:{
                        5: 'Guest',
                        1: 'Public',
                        2: 'Registered',
                        3: 'Special'
                    }
                } 
            }
        }
    }
}