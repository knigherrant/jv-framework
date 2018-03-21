{
    name: 'Ajax call',
    version: '1.0.0',
    config: {
        jsonp:{
            label: 'JSONP support',
            field: 'input',
            type: 'checkbox',
            value: false
        },
        delay:{
            label: 'Auto load delay (0 to disable)',
            field: 'input',
            validates: {
                required: true,
                number: true
            },
            value: 30
        },
        modalwidth:{
            label: 'Default modal width',
            validates:{
                number:true
            },
            field: 'input',
            value: 500
        }
    }
}