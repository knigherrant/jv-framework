<?php JFormFieldJVCustom::import('positions'); ?>
{
    name: 'Docks',
    version: '1.0.0',
    config: {
        config: {
            label: 'Docks',
            'class': 'none',
            field: 'multi',
            filter: true,
            item: {
                field: 'group',
                toggle: true,
                label: 'Add new dock',
                titlefield: 'title',
                item:{
                    title:{
                        field: 'input',
                        label: 'title'
                    },
                    content: {
                        field: 'filter',
                        label: 'Assign dock as',
                        'class': 'none',
                        item: {
                            position: {
                                field: 'select2',
                                label: 'Position',
                                data: {results: CustomField.datas.positions},
                                validates: {required: true}
                            },
                            selector:{
                                field: 'input',
                                label: 'Selector',
                                validates: {required: true}
                            }
                        }
                    },
                    delay: {
                        field: 'input',
                        label: 'Delay toggle',
                        value: 300,
                        validates:{ number: true, required: true }
                    },
                    duration: {
                        field: 'input',
                        label: 'Duration toggle',
                        value: 500,
                        validates:{ number: true, required: true }
                    },
                    width: {
                        field: 'input',
                        label: 'Width dock',
                        value: '200',
                        validates:{ reg: /^auto|\d+(px|%)?$/ }
                    },
                    height: {
                        field: 'input',
                        label: 'Height dock',
                        value: '200',
                        validates:{reg: /^auto|\d+(px|%)?$/}
                    },
                    margin: {
                        field: 'input',
                        label: 'Dock margin',
                        value: 200,
                        validates:{ number: true, required: true }
                    },
                    display:{
                        field: 'select2',
                        label: 'Display at',
                        value: 'top-right',
                        item: {
                            'top-left': 'Top and align left',
                            'top-right': 'Top and align right',
                            'left-top': 'Left and align top',
                            'left-bottom': 'Left and align bottom',
                            'right-top': 'Right and align top',
                            'right-bottom': 'Right and align bottom',
                            'bottom-left': 'Bottom and align left',
                            'bottom-right': 'Bottom and align right'
                        }
                    },
                    openOn: {
                        field: 'select',
                        label: 'Open on',
                        item: {
                            click: 'Mouse click',
                            mouseenter: 'Mouse hover'
                        }
                    },
                    closeOn: {
                        field: 'select',
                        label: 'Close on',
                        item: {
                            click: 'Mouse click',
                            mouseleave: 'Mouse cancel hover'
                        }
                    },
                    hideOnCancel: {
                        field: 'input',
                        type: 'checkbox',
                        label: 'Hide on cancel active',
                        value: true
                    },
                    btnCss: {
                        field: 'select2',
                        tags:[],
                        label: 'Button custom css'
                    }
                }
            }
        }
    }
}