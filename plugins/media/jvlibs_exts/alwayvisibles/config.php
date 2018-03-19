<?php JFormFieldJVCustom::import('assignment');?>
{
    name: 'Alway visibles top',
    version: '1.0.0',
    config: {
        config: {
            label: 'Alway visibles top',
            'class': 'none',
            field: 'multi',
            sortable: true,
            filter: true,
            item: {
                field: 'group',
                toggle: true,
                label: 'Add new groups',
                titlefield: 'title',
                item:{
                    title:{
                        field: 'input',
                        label: 'title'
                    },
                    selector: {
                        field: 'input',
                        label: 'Selector assign',
                        validates:{required: true }
                    },
                    hideWith: {
                        field: 'input',
                        label: 'Hide with selector'
                    },
                    margin: {
                        field: 'input',
                        label: 'Visible margin',
                        value: 0,
                        validates:{ number: true, required: true }
                    },
                    hideNext: {
                        field: 'input',
                        type: 'checkbox',
                        label: 'Hide on next',
                        value: true
                    }
                }
            }
        }
    }
}